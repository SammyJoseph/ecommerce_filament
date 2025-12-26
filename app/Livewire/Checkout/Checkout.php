<?php

namespace App\Livewire\Checkout;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\VariantSize;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Checkout extends Component
{
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $address;
    public $reference;
    public $notes;
    public $shippingAddresses = [];
    public $selectedShippingAddressId = '';
    public $paymentMethod = 'mercadopago';
    public $isEditingAddress = false;

    // Address fields
    public $department = '';
    public $province = '';
    public $district = '';
    public $address_type = 'home';
    
    // Ubigeo Data
    public $departments = [];
    public $provinces = [];
    public $districts = [];
    
    public $selectedDeptId = '';
    public $selectedProvId = '';
    public $selectedDistId = '';

    protected $ubigeoService;

    public function boot(\App\Services\UbigeoService $ubigeoService)
    {
        $this->ubigeoService = $ubigeoService;
    }

    protected $rules = [
        'firstName'     => 'required|min:2',
        'lastName'      => 'required|min:2',
        'email'         => 'required|email',
        'phone'         => 'required',
        'address'       => 'required',
        'paymentMethod' => 'required'
    ];

    public function editAddress()
    {
        $this->isEditingAddress = true;
        
        $address = UserAddress::where('id', $this->selectedShippingAddressId)
            ->where('user_id', auth()->id())
            ->first();

        if ($address) {
            $this->department = $address->department;
            $this->province = $address->province;
            $this->district = $address->district;
            $this->address_type = $address->address_type;
            
            $this->reverseLookupUbigeo();
        }
    }

    public function cancelEditAddress()
    {
        $this->isEditingAddress = false;
        $this->updatedSelectedShippingAddressId($this->selectedShippingAddressId);
    }

    public function saveAddress()
    {
        $this->validate([
            'address' => 'required',
            'reference' => 'nullable',
            'department' => 'required',
            'province' => 'required',
            'district' => 'required',
            'address_type' => 'required|in:home,work,other',
        ]);

        $address = UserAddress::where('id', $this->selectedShippingAddressId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $address->update([
            'address' => $this->address,
            'reference' => $this->reference,
            'department' => $this->department,
            'province' => $this->province,
            'district' => $this->district,
            'address_type' => $this->address_type,
        ]);

        $this->isEditingAddress = false;
        $this->shippingAddresses = auth()->user()->addresses;
    }

    public function mount()
    {
        $this->loadDepartments();
        if (auth()->check()) {
            $user = auth()->user();
            $this->firstName = $user->name;
            $this->lastName = $user->last_name ?? '';
            $this->email = $user->email;
            $this->phone = $user->phone_number ?? '';
            $this->shippingAddresses = $user->addresses;
            
            $sessionAddressId = session('selected_address_id');
            $targetAddress = null;

            if ($sessionAddressId) {
                $targetAddress = $user->addresses->firstWhere('id', $sessionAddressId);
            }

            if (!$targetAddress) {
                $targetAddress = $user->defaultAddress;
            }

            if ($targetAddress) {
                $this->selectedShippingAddressId = $targetAddress->id;
                $this->address = $targetAddress->address;
                $this->reference = $targetAddress->reference ?? '';
            } else {
                 $this->address = '';
                 $this->reference = '';
                 $this->selectedShippingAddressId = '';
            }
        } else {
            // Load from session for guests if available
            $this->selectedDeptId = session('selected_department');
            if ($this->selectedDeptId) {
                $this->updatedSelectedDeptId($this->selectedDeptId);
                
                $this->selectedProvId = session('selected_province');
                if ($this->selectedProvId) {
                    $this->updatedSelectedProvId($this->selectedProvId);
                    
                    $this->selectedDistId = session('selected_district');
                    if ($this->selectedDistId) {
                        $this->updatedSelectedDistId($this->selectedDistId);
                    }
                }
            }
        }
    }

    public function placeOrder()
    {
        $this->validate();

        if (!$this->validateStock()) {
            return;
        }

        if (empty($this->selectedShippingAddressId)) {
            $this->validate([
                'department' => 'required',
                'province' => 'required',
                'district' => 'required',
            ], [
                'department.required' => 'El departamento es requerido.',
                'province.required' => 'La provincia es requerida.',
                'district.required' => 'El distrito es requerido.',
            ]);
        }

        if ($this->paymentMethod === 'mercadopago') {
            DB::beginTransaction();
            try {
                $order = $this->createOrder();
                $redirect = $this->processMercadoPago($order->id);
                
                $this->reduceStock();

                DB::commit();
                return $redirect;
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('MP Error: ' . $e->getMessage());
                session()->flash('error', 'Error al procesar: ' . $e->getMessage());
            }
        }
    }

    private function createOrder()
    {
        $userId = $this->resolveUserId();
        $shippingAddressId = $this->resolveAddressId($userId);

        $order = Order::create([
            'user_id' => $userId,
            'number' => 'ORD-' . strtoupper(Str::random(5)),
            'total_amount' => $this->calculateTotal() - $this->shipping,
            'shipping_amount' => $this->shipping,
            'discount_amount' => $this->discount,
            'status' => 'pending_payment',
            'currency' => 'PEN',
            'shipping_address_id' => $shippingAddressId,
            'notes' => "Notas: " . $this->notes,
        ]);

        $cartItems = Cart::instance('shopping')->content();
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->options->product_id ?? $item->id,
                'quantity' => $item->qty,
                'price' => (float) $item->price,
                'options' => $item->options->toArray(),
            ]);
        }

        return $order;
    }

    private function reduceStock()
    {
        $cartItems = Cart::instance('shopping')->content();
        foreach ($cartItems as $item) {
            if (isset($item->options->variant_size_id) && $variantSize = VariantSize::find($item->options->variant_size_id)) {
                $variantSize->decrement('stock', $item->qty);
            } elseif ($product = Product::find($item->options->product_id ?? $item->id)) {
                $product->decrement('stock', $item->qty);
            }
        }
    }

    private function validateStock()
    {
        $cartItems = Cart::instance('shopping')->content();
        foreach ($cartItems as $item) {
            $stock = 0;
            
            if (isset($item->options->variant_size_id)) {
                $variantSize = VariantSize::find($item->options->variant_size_id);
                if ($variantSize) {
                    $stock = $variantSize->stock;
                }
            } elseif ($product = Product::find($item->options->product_id ?? $item->id)) {
                $stock = $product->stock;
            }

            if ($item->qty > $stock) {
                session()->flash('error', "Stock insuficiente para '{$item->name}'. Disponibles: {$stock}");
                return false;
            }
        }
        return true;
    }

    public function processMercadoPago($orderId)
    {
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
        $client = new PreferenceClient();

        if (app()->environment('local')) {
            $backUrls = [
                "success" => "https://boutique.artisam.dev/payment/success",
                "failure" => "https://boutique.artisam.dev/payment/failure",
                "pending" => "https://boutique.artisam.dev/payment/pending"
            ];
            $notificationUrl = "https://sagacious-attestable-coy.ngrok-free.dev/mp/webhook";
        } else {
            $backUrls = [
                "success" => route('payment.success'),
                "failure" => route('payment.failure'),
                "pending" => route('payment.pending')
            ];
            $notificationUrl = route('mp.webhook');
        }

        $preference = $client->create([
            "items" => $this->getCartItems(),
            "payer" => [
                "name" => $this->firstName,
                "surname" => $this->lastName,
                "email" => $this->email,
                "phone" => [
                    "area_code" => "51",
                    "number" => $this->phone
                ],
                "address" => [
                    "street_name" => $this->address
                ]
            ],
            "external_reference" => (string) $orderId, 
            "back_urls" => $backUrls,
            "auto_return" => "approved",
            "notification_url" => $notificationUrl,
            "shipments" => [
                "cost" => $this->shipping,
                "mode" => "not_specified",
            ],
        ]);
        
        return redirect()->away($preference->init_point);
    }    

    private function resolveUserId()
    {
        if (auth()->check()) {
            return auth()->id();
        }

        $user = User::where('email', $this->email)->first();

        if ($user) {
            return $user->id; // no auto-logueamos
        }

        $user = User::create([
            'name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone_number' => $this->phone,
            'password' => bcrypt(uniqid()),
        ]);

        $user->assignRole('user');

        auth()->login($user);

        return $user->id;
    }

    private function resolveAddressId($userId)
    {
        if (auth()->check() && $this->selectedShippingAddressId) {
            $shippingAddress = UserAddress::where('id', $this->selectedShippingAddressId)
                ->where('user_id', $userId)
                ->firstOrFail();
            return $shippingAddress->id;
        } else {
            $shippingAddress = new UserAddress();
            $shippingAddress->user_id = $userId;
            $shippingAddress->fill([
                'department' => $this->department,
                'province' => $this->province,
                'district' => $this->district,
                'address' => $this->address,
                'reference' => $this->reference ?? '',
                'address_type' => $this->address_type,
                'is_default' => true,
            ]);
            $shippingAddress->skipLimitCheck = true; 
            $shippingAddress->save();
            return $shippingAddress->id;
        }
    }

    public function updatedSelectedShippingAddressId($value)
    {
        $this->isEditingAddress = false;
        if ($value) {
            $address = UserAddress::where('id', $value)
                ->where('user_id', auth()->id())
                ->first();
            if ($address) {
                $this->address = $address->address;
                $this->reference = $address->reference ?? '';
                
                // Store in session for consistency if they go back to cart
                session()->put('selected_address_id', $value);
            }
        } else {
            $this->address = '';
            $this->reference = '';
            // Clear session if desired, or keep last valid? Usually clearing makes sense if they explicitly select "new address"
            // But logic above for new address is value=""
            session()->forget('selected_address_id');
        }
    }

    public function getSubtotalProperty() {
        return (float) str_replace(',', '', Cart::instance('shopping')->subtotal()); 
    }
    
    public function getShippingProperty() { 
        $deptId = null;

        if ($this->selectedShippingAddressId) {
             $address = collect($this->shippingAddresses)->where('id', $this->selectedShippingAddressId)->first();
             if ($address) {
                 $dept = collect($this->departments)->firstWhere('nombre_ubigeo', $address->department);
                 $deptId = $dept['id_ubigeo'] ?? null;
             }
        } elseif ($this->selectedDeptId) {
            $deptId = $this->selectedDeptId;
        } else {
             $deptId = session('selected_department');
        }

        // Use service with fallback or direct call
        return $deptId ? $this->ubigeoService->getShippingRate($deptId) : 0;
    }

    public function getDiscountProperty() {
        if (session()->has('coupon')) {
            $coupon = session('coupon');
            if ($coupon['type'] === 'fixed') return $coupon['value'];
            if ($coupon['type'] === 'percentage') return ($this->subtotal * $coupon['value']) / 100;
        }
        return 0;
    }

    public function calculateTotal() {
        return max(0, $this->subtotal - $this->discount + $this->shipping);
    }

    protected function loadDepartments()
    {
        $this->departments = $this->ubigeoService->getDepartments();
    }

    public function updatedSelectedDeptId($value)
    {
        $dept = collect($this->departments)->firstWhere('id_ubigeo', $value);
        $this->department = $dept['nombre_ubigeo'] ?? '';
        
        $this->selectedProvId = '';
        $this->selectedDistId = '';
        $this->province = '';
        $this->district = '';
        $this->provinces = [];
        $this->districts = [];

        if ($value) {
            $this->provinces = $this->ubigeoService->getProvinces($value);
        }
    }

    public function updatedSelectedProvId($value)
    {
        $prov = collect($this->provinces)->firstWhere('id_ubigeo', $value);
        $this->province = $prov['nombre_ubigeo'] ?? '';
        
        $this->selectedDistId = '';
        $this->district = '';
        $this->districts = [];

        if ($value) {
            $this->districts = $this->ubigeoService->getDistricts($value);
        }
    }

    public function updatedSelectedDistId($value)
    {
        $dist = collect($this->districts)->firstWhere('id_ubigeo', $value);
        $this->district = $dist['nombre_ubigeo'] ?? '';
    }

    protected function reverseLookupUbigeo()
    {
        // 1. Find Department ID
        $this->selectedDeptId = $this->ubigeoService->getDepartmentIdByName($this->department);
        
        if ($this->selectedDeptId) {
            // Load Provinces
            $this->provinces = $this->ubigeoService->getProvinces($this->selectedDeptId);
            
            // 2. Find Province ID
            $this->selectedProvId = $this->ubigeoService->getProvinceIdByName($this->selectedDeptId, $this->province);
            
            if ($this->selectedProvId) {
                // Load Districts
                $this->districts = $this->ubigeoService->getDistricts($this->selectedProvId);
                
                // 3. Find District ID
                $this->selectedDistId = $this->ubigeoService->getDistrictIdByName($this->selectedProvId, $this->district);
            }
        }
    }

    private function getCartItems() {
        $items = [];
        $cartContent = Cart::instance('shopping')->content();
        
        Log::info('Checkout: Processing cart items', [
            'count' => $cartContent->count(),
            'content_dump' => $cartContent->toArray(),
            'discount_applied' => $this->discount
        ]);

        foreach ($cartContent as $item) {
            $items[] = [
                "id" => $item->options->product_id ?? $item->id,
                "title" => $item->name,
                "quantity" => $item->qty,
                "unit_price" => (float) $item->price,
                "currency_id" => "PEN"
            ];
        }

        // Agregar el descuento como un item negativo si existe
        if ($this->discount > 0) {
            $couponInfo = session('coupon');
            $couponCode = $couponInfo['code'] ?? 'DESCUENTO';
            
            $items[] = [
                "id" => "discount-" . $couponCode,
                "title" => "Descuento por cupón: " . $couponCode,
                "quantity" => 1,
                "unit_price" => -1 * (float) $this->discount,  // Precio negativo
                "currency_id" => "PEN"
            ];
        }

        return $items;
    }

    public function render()
    {
        Cart::instance('shopping');
        $productsInCart = Cart::content();

        return view('livewire.checkout.checkout', [
            'cartItems' => $productsInCart,
            'qty' => $productsInCart->sum('qty'),
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'total' => $this->calculateTotal(),
        ]);
    }
}