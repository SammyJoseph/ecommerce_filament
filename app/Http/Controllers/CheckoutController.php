<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Exceptions\MPApiException;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Cart::instance('shopping')->count() == 0) return redirect()->route('cart.index');

        $preference = $this->createPreference();
        
        return view('checkout.index', [
            'preferenceId' => $preference->id
        ]);
    }    

    private function createPreference()
    {
        try {
            MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
            $client = new PreferenceClient();            

            $preferenceData = [
                "items" => $this->getCartItems(), 
                "payer" => ["email" => "test_user@example.com", "name" => "Test", "surname" => "User"],
                "payment_methods" => ["installments" => 12],
                "back_urls" => [
                    "success" => "https://boutique.artisam.dev/payment/success",
                    "failure" => "https://boutique.artisam.dev/payment/failure",
                    "pending" => "https://boutique.artisam.dev/payment/pending"
                ],
                "auto_return" => "approved",
                "notification_url" => "https://sagacious-attestable-coy.ngrok-free.dev/mp/webhook",
            ];

            $preference = $client->create($preferenceData);

            return $preference;

        } catch (MPApiException $e) {
            Log::error('Error al crear preferencia de MercadoPago: ' . $e->getMessage());
            Log::error('Response details: ' . $e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error general al crear preferencia: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getCartItems()
    {
        Cart::instance('shopping');
        $cart = Cart::content();

        $items = [];
        foreach ($cart as $item) {
            $items[] = [
                "id" => $options->product_id ?? $item->id,
                "title" => $item->name,
                "quantity" => $item->qty,
                "unit_price" => (float) $item->price,
                "color" => $item->options->color ?? null,
                "size" => $item->options->size ?? null,
            ];
        }
        return $items;
    }

    public function thanks()
    {
        return view('checkout.thanks');
    }
}
