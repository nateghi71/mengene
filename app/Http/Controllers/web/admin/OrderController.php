<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $this->authorize('viewIndex' , Order::class);

        $orders = Order::paginate(10);
        return view('admin.orders.index' , compact('orders'));
    }

    public function create()
    {
        $this->authorize('create' , Order::class);

        $users = User::has('ownedBusiness')->get();
        return view('admin.orders.create' , compact('users'));
    }

    public function store(Request $request)
    {
        $this->authorize('create' , Order::class);

        $request->validate([
            'user_id' => 'required',
            'amount' => 'required',
            'tax_amount' => 'required',
            'paying_amount' => 'required' ,
            'payment_type' => 'required' ,
            'order_type' => 'required',
            'payment_status' => 'nullable',
            'description' => 'nullable'
        ]);

        $business_id = Business::where('user_id' , $request->user_id)->first()->id;
        Order::create([
            'user_id' => $request->user_id,
            'business_id' => $business_id,
            'amount' => $request->amount,
            'tax_amount' => $request->tax_amount,
            'paying_amount' => $request->paying_amount ,
            'payment_type' => $request->payment_type ,
            'order_type' => $request->order_type,
            'payment_status' => $request->has('payment_status') ? 1 : 0,
            'description' => $request->description
        ]);

        return redirect()->route('admin.orders.index')->with('message' , 'سفارش مورد نظر ثبت شد.');
    }

    public function show(Order $order)
    {
        $this->authorize('viewShow' , Coupon::class);

        return view('admin.orders.show' , compact('order'));
    }

    public function edit(Order $order)
    {
        $this->authorize('edit' , Order::class);

        $users = User::has('ownedBusiness')->get();
        return view('admin.orders.edit' , compact('order' , 'users'));
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('edit' , Order::class);

        $request->validate([
            'user_id' => 'required',
            'amount' => 'required',
            'tax_amount' => 'required',
            'paying_amount' => 'required' ,
            'payment_type' => 'required' ,
            'order_type' => 'required',
            'payment_status' => 'nullable',
            'description' => 'nullable'
        ]);

        $business_id = Business::where('user_id' , $request->user_id)->first()->id;
        $order->update([
            'user_id' => $request->user_id,
            'business_id' => $business_id,
            'amount' => $request->amount,
            'tax_amount' => $request->tax_amount,
            'paying_amount' => $request->paying_amount ,
            'payment_type' => $request->payment_type ,
            'order_type' => $request->order_type,
            'payment_status' => $request->has('payment_status') ? 1 : 0,
            'description' => $request->description
        ]);

        return redirect()->route('admin.orders.index')->with('message' , 'سفارش مورد نظر ویرایش شد.');

    }

    public function destroy(Order $order)
    {
        $this->authorize('delete' , Order::class);

        $order->delete();
        return back()->with('message' , 'سفارش موردنظر حذف شد.');
    }
}
