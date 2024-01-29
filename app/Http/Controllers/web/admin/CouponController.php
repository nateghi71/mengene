<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $this->authorize('viewIndex' , Coupon::class);

        $coupons = Coupon::paginate(10);
        return view('admin.coupons.index' , compact('coupons'));
    }

    public function create()
    {
        $this->authorize('create' , Coupon::class);

        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create' , Coupon::class);

        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:coupons,code',
            'percentage' => 'required',
            'expire_date' => 'required',
            'description' => 'nullable'
        ]);

        Coupon::create([
            'name' => $request->name,
            'code' => $request->code,
            'percentage' => $request->percentage,
            'expire_date' => $request->expire_date,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.coupons.index')->with( 'message' ,'کوپن مورد نظر ایجاد شد');
    }

    public function show(Coupon $coupon)
    {
        $this->authorize('viewShow' , Coupon::class);

        return view('admin.coupons.show' , compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        $this->authorize('edit' , Coupon::class);

        return view('admin.coupons.edit' , compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $this->authorize('edit' , Coupon::class);

        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'percentage' => 'required',
            'expire_date' => 'required',
            'description' => 'nullable'
        ]);

        $coupon->update([
            'name' => $request->name,
            'code' => $request->code,
            'percentage' => $request->percentage,
            'expire_date' => $request->expire_date,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.coupons.index')->with( 'message' ,'کوپن مورد نظر بروزرسانی شد');
    }

    public function destroy(Coupon $coupon)
    {
        $this->authorize('delete' , Coupon::class);

        $coupon->delete();
        return back();
    }
}
