<?php

namespace App\Livewire\Checkout;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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

    protected $rules = [
        'firstName'     => 'required|min:2',
        'lastName'      => 'required|min:2',
        'email'         => 'required|email',
        'phone'         => 'required',
        'address'       => 'required',
        'paymentMethod' => 'required'
    ];

    public function mount()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $this->firstName = $user->name;
            $this->lastName = $user->last_name ?? '';
            $this->email = $user->email;
            $this->phone = $user->phone_number ?? '';
            $this->address = $user->defaultAddress->address ?? '';
            $this->reference = $user->defaultAddress->reference ?? '';
            $this->shippingAddresses = $user->addresses;
            $this->selectedShippingAddressId = $user->defaultAddress?->id ?? '';
        }
    }

    public function placeOrder()
    {
        $this->validate();

        if ($this->paymentMethod === 'mercadopago') {
            DB::beginTransaction();
            try {
                $order = $this->createOrder();
                $redirect = $this->processMercadoPago($order->id);
                
                DB::commit();
                return $redirect;
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('MP Error: ' . $e->getMessage());
                session()->flash('error', 'Error al procesar: ' . $e->getMessage());
            }
        } 
    }

    public function processMercadoPago($orderId)
    {
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
        $client = new PreferenceClient();

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
            "back_urls" => [
                "success" => "https://boutique.artisam.dev/payment/success",
                "failure" => "https://boutique.artisam.dev/payment/failure",
                "pending" => "https://boutique.artisam.dev/payment/pending"
            ],
            "auto_return" => "approved",
            "notification_url" => "https://sagacious-attestable-coy.ngrok-free.dev/mp/webhook",
            "shipments" => [
                "cost" => $this->shipping,
                "mode" => "not_specified",
            ],
        ]);

        return redirect()->away($preference->init_point);
    }

    private function createOrder()
    {
        $contactInfo = "Cliente: {$this->firstName} {$this->lastName} | Tel: {$this->phone}";

        $userId = $this->resolveUserId();
        $shippingAddressId = $this->resolveAddressId();

        $order = Order::create([
            'user_id' => $userId,
            'number' => 'ORD-' . strtoupper(uniqid()),
            'total_amount' => $this->calculateTotal() - $this->shipping,
            'shipping_amount' => $this->shipping,
            'status' => 'pending',
            'currency' => 'PEN',
            'shipping_address_id' => $shippingAddressId,
            'notes' => $contactInfo . " | Notas: " . $this->notes,
        ]);

        foreach (Cart::instance('shopping')->content() as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->options->product_id ?? $item->id,
                'quantity' => $item->qty,
                'price' => (float) $item->price,
            ]);
        }

        return $order;
    }

    private function resolveUserId()
    {
        if (auth()->check()) {
            return auth()->id();
        }

        $user = User::where('email', $this->email)->first();

        if ($user) {
            return $user->id;
        }

        $user = User::create([
            'name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone_number' => $this->phone,
            'password' => bcrypt(uniqid()),
        ]);

        auth()->login($user);

        return $user->id;
    }

    private function resolveAddressId()
    {
        if (auth()->check() && $this->selectedShippingAddressId) {
            $shippingAddress = UserAddress::where('id', $this->selectedShippingAddressId)
                ->where('user_id', $userId)
                ->firstOrFail();
            return $shippingAddress->id;
        } else {
            $shippingAddress = UserAddress::create([
                'user_id' => $userId,
                'address' => $this->address,
                'reference' => $this->reference ?? '',
            ]);
            return $shippingAddress->id;
        }
    }

    public function updatedSelectedShippingAddressId($value)
    {
        if ($value) {
            $address = UserAddress::where('id', $value)
                ->where('user_id', auth()->id())
                ->first();
            if ($address) {
                $this->address = $address->address;
                $this->reference = $address->reference ?? '';
            } else {
                $this->address = '';
                $this->reference = '';
            }
        }
    }

    public function getSubtotalProperty() {
        return (float) str_replace(',', '', Cart::instance('shopping')->subtotal()); 
    }
    
    public function getShippingProperty() { 
        return session('shipping_cost', 0); 
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

    private function getCartItems() {
        $items = [];
        $cartContent = Cart::instance('shopping')->content();
        
        Log::info('Checkout: Processing cart items', [
            'count' => $cartContent->count(),
            'content_dump' => $cartContent->toArray()
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
        return $items;
    }

    public function render()
    {
        return view('livewire.checkout.checkout', [
            'cartItems' => Cart::instance('shopping')->content(),
            'subtotal' => $this->subtotal,
            'shipping' => $this->shipping,
            'discount' => $this->discount,
            'total' => $this->calculateTotal(),
        ]);
    }
}