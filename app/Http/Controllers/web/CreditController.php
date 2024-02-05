<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;
use mysql_xdevapi\Collection;

class CreditController extends Controller
{
    public function index()
    {
        $this->authorize('isOwner' , Business::class);

        if (auth()->user()->isFreeUser())
            return back()->with('message' , 'شما به این امکانات دسترسی ندارید.');

        return view('credit.index');
    }

    public function checkout(Request $request)
    {
        $this->authorize('isOwner' , Business::class);
        $request->amount = to_english_numbers($request->amount);

        if (auth()->user()->isFreeUser())
            return back()->with('message' , 'شما به این امکانات دسترسی ندارید.');

        $request->validate([
            'amount' => 'required|numeric|between:1000,99999999',
        ]);
        $amount = $request->amount;
        $tax = $request->amount * 0.09;
        $payment_amount = $amount + $tax;
        $order = ['amount' => $amount,'tax' => $tax,'payment' => $payment_amount];
        return view('credit.checkout' , compact('order'));
    }
}
