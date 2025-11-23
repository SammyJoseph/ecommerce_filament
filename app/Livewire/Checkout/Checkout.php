<?php

namespace App\Livewire\Checkout;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use App\Models\Order; 
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

        return Order::create([
            'user_id' => auth()->id() ?? 1,
            'number' => 'ORD-' . strtoupper(uniqid()),
            'total_amount' => $this->calculateTotal() - $this->shipping,
            'shipping_amount' => $this->shipping,
            'status' => 'pending',
            'currency' => 'PEN',
            'shipping_street' => $this->address,
            'notes' => $contactInfo . " | Notas: " . $this->notes,
        ]);
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
        foreach (Cart::instance('shopping')->content() as $item) {
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