<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Cart::instance('shopping')->count() == 0) {
            return redirect()->route('cart.index');
        }

        return view('checkout.index');
    }

    public function thanks()
    {
        return view('checkout.thanks');
    }
}