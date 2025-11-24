<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function myAccount()
    {
        $user = auth()->user();
        return view('user.my-account', compact('user'));
    }

    public function orders()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('user.orders', compact('user', 'orders'));
    }

    public function orderDetails(Order $order)
    {
        $user = auth()->user();

        if ($order->user_id !== $user->id) {
            abort(403);
        }

        $order->load('orderItems.product');

        return view('user.order-details', compact('user', 'order'));
    }

    public function address()
    {
        $user = auth()->user();
        $addresses = $user->addresses()->orderBy('created_at', 'desc')->paginate(10);
        
        return view('user.address', compact('user', 'addresses'));
    }

    public function accountDetails()
    {
        $user = auth()->user();
        return view('user.account-details', compact('user'));
    }

    public function download()
    {
        $user = auth()->user();
        return view('user.download', compact('user'));
    }

    public function paymentMethod()
    {
        $user = auth()->user();
        return view('user.payment-method', compact('user'));
    }
}
