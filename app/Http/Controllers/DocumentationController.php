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
    public function loginBuyer()
    {
        Auth::logout();
        Auth::loginUsingId(2);
        return redirect()->route('index');
    }

    public function loginAdmin()
    {
        Auth::logout();
        Auth::loginUsingId(1);
        return redirect('/admin');
    }
}
