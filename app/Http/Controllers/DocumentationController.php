<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentationController extends Controller
{
    public function index()
    {
        return view('doc');
    }

    public function loginAdmin()
    {
        Auth::logout();
        Auth::loginUsingId(2);
        return redirect('/admin');
    }

    public function loginBuyer()
    {
        Auth::logout();
        Auth::loginUsingId(3);
        return redirect()->route('shop');
    }    
}
