<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use mysql_xdevapi\Collection;

class CreditController extends Controller
{

    public function index(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|between:1000,99999999',
            'order_type' => 'required',
        ]);
        $order = $request->except('_token');
        $order['tax'] = $order['amount'] * 0.09;

        return view('premium.checkout' , compact('order'));
    }

    public function Increase_credit()
    {
        return view('premium.Increase_account_credit');
    }

    public function buy_credit(Request $request)
    {
        $business = auth()->user()->business();
        $business->wallet += $request->amount;
        $business->save();
        return redirect()->route('business.index')->with(['message' => 'حساب شما با موفقیت شارژ شد.']);
    }
}
