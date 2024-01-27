<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use mysql_xdevapi\Collection;

class CreditController extends Controller
{
    public function index(Request $request)
    {
        $order = $request->all();
//        dd($order);
        return view('premium.checkout' , compact('order'));
    }

    public function Increase_credit()
    {
        return view('premium.Increase_account_credit');
    }
}
