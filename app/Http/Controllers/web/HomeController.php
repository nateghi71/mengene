<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Customer;
use App\Models\Landowner;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.home');
    }

    public function public_customers()
    {
        $customers = Customer::where('access_level' , 'public')->whereNot('status' , 'deActive')->orderBy('is_star', 'desc')
            ->orderBy('expire_date', 'asc')->paginate(10)->withQueryString();

        foreach ($customers as $customer) {
            if ($customer->getRawOriginal('expire_date') > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($customer->getRawOriginal('expire_date')) + 1;
                $customer->daysLeft = $daysLeft;
            }
        }

        return view('home.index_public_customers', compact('customers'));
    }
    public function show_public_customers(Customer $customer)
    {
        if ($customer->getRawOriginal('expire_date') > Carbon::now()) {
            $daysLeft = Carbon::now()->diffInDays($customer->getRawOriginal('expire_date')) + 1;
            $customer->daysLeft = $daysLeft;
        }

        return view('home.show_public_customer', compact('customer'));
    }
    public function public_landowners()
    {
        $landowners = Landowner::where('access_level' , 'public')->whereNot('status' , 'deActive')->orderBy('is_star', 'desc')
            ->orderBy('expire_date', 'asc')->paginate(10)->withQueryString();

        foreach ($landowners as $landowner) {
            if ($landowner->getRawOriginal('expire_date') > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($landowner->getRawOriginal('expire_date')) + 1;
                $landowner->daysLeft = $daysLeft;
            }
        }

        return view('home.index_public_landowners', compact('landowners'));
    }
    public function show_public_landowners(Landowner $landowner)
    {
        if ($landowner->getRawOriginal('expire_date') > Carbon::now()) {
            $daysLeft = Carbon::now()->diffInDays($landowner->getRawOriginal('expire_date')) + 1;
            $landowner->daysLeft = $daysLeft;
        }

        return view('home.show_public_landowner', compact('landowner'));
    }

    public function getProvinceCitiesList(Request $request)
    {
        $cities = City::where('province_id', $request->province_id)->get();
        return $cities;
    }
}
