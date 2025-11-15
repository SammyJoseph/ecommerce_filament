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

    public function process(Request $request)
    {
        
    }

    public function thanks()
    {
        return view('checkout.thanks');
    }

    private function createPreference()
    {
        try {
            MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
            $client = new PreferenceClient();            

            $preferenceData = [
                "items" => $this->getCartItems(),
                "back_urls" => [
                    "success" => url('/payment/success'),
                    "failure" => url('/payment/failure'),
                    "pending" => url('/payment/pending'),
                ],
                // "auto_return" => "approved",
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
                "title" => $item->name,
                "quantity" => $item->qty,
                "unit_price" => $item->price,
            ];
        }
        return $items;
    }
}
