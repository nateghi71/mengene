<?php

namespace App\Http\Controllers\web;

use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\HelperClasses\UpdateStatusFile;
use App\Http\Controllers\Controller;
use App\Models\Landowner;
use App\Models\RandomLink;
use App\Models\User;
use Hekmatinasser\Verta\Facades\Verta;
use http\Url;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Business;
use Carbon\Carbon;
use App\Http\Controllers\API\MyBaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Customer as CustomerResource;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function َََََindex($status)
    {
        if ($status == 'active' || $status == 'unknown' || $status == 'deActive')
        {
            $this->authorize('viewAny' , Customer::class);
            $user = auth()->user();

            $business = $user->business();

            $buyCustomers = $business->customers()->where('status', $status)->where('type_sale' , 'buy')
                ->orderBy('is_star', 'desc')->orderBy('expire_date', 'asc')->paginate(
                    $perPage = 5, $columns = ['*'], $pageName = 'buy'
                )->fragment('buy')->withQueryString();

            foreach ($buyCustomers as $customer) {
                if ($customer->expire_date > Carbon::now()) {
                    $daysLeft = Carbon::now()->diffInDays($customer->expire_date) + 1;
                    $customer->daysLeft = $daysLeft;
                }
            }

            $rahnCustomers = $business->customers()->where('status', $status)->where('type_sale' , 'rahn')
                ->orderBy('is_star', 'desc')->orderBy('expire_date', 'asc')->paginate(
                    $perPage = 5, $columns = ['*'], $pageName = 'rahn'
                )->fragment('rahn')->withQueryString();

            foreach ($rahnCustomers as $customer) {
                if ($customer->expire_date > Carbon::now()) {
                    $daysLeft = Carbon::now()->diffInDays($customer->expire_date) + 1;
                    $customer->daysLeft = $daysLeft;
                }
            }

            return view('customer.index', compact('buyCustomers' , 'rahnCustomers'));
        }

        abort(404);
    }

    public function show(Customer $customer)
    {
        $this->authorize('view' , $customer);
        return view('customer.show', compact('customer'));
    }

    public function create()
    {
        $this->authorize('create' , Customer::class);
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $request['selling_price'] = str_replace( ',', '', $request->selling_price );
        $request['rahn_amount'] = str_replace( ',', '', $request->rahn_amount );
        $request['rent_amount'] = str_replace( ',', '', $request->rent_amount );

        $this->authorize('create' , Customer::class);
        $request->validate([
            'name' => 'required',
            'number' => 'required|numeric',
            'city' => 'required',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'scale' => 'required|numeric',
            'number_of_rooms' => 'required|numeric',
            'description' => 'required',
            'rahn_amount' => [Rule::requiredIf($request->type_sale == 'rahn') , 'numeric'],
            'rent_amount' => [Rule::requiredIf($request->type_sale == 'rahn') , 'numeric'],
            'selling_price' => [Rule::requiredIf($request->type_sale == 'buy') , 'numeric'],
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'floor_number' => 'required|numeric',
            'is_star' => 'nullable',
            'expire_date' => 'required'
        ]);

        $user = auth()->user();
        Customer::create([
            'name' => $request->name,
            'number' => $request->number,
            'city' => $request->city,
            'type_sale' => $request->type_sale,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'scale' => $request->scale,
            'number_of_rooms' => $request->number_of_rooms,
            'description' => $request->description,
            'rahn_amount' => $request->filled('rahn_amount') ? $request->rahn_amount : null,
            'rent_amount' => $request->filled('rent_amount') ? $request->rent_amount : null,
            'selling_price' => $request->filled('selling_price') ? $request->selling_price : null,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'floor' => $request->floor,
            'floor_number' => $request->floor_number,
            'business_id' => $user->business()->id,
            'user_id' => $user->id,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'expire_date' => Verta::parse($request->expire_date)->datetime()->format('Y-m-d')
        ]);
        return redirect()->route('customer.index',['status' => 'active']);
    }

    public function edit(Customer $customer)
    {
        $customer->expire_date = verta($customer->expire_date)->format('Y-m-d');
        $this->authorize('update', $customer);
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request['selling_price'] = str_replace( ',', '', $request->selling_price );
        $request['rahn_amount'] = str_replace( ',', '', $request->rahn_amount );
        $request['rent_amount'] = str_replace( ',', '', $request->rent_amount );

        $this->authorize('update', $customer);

        $request->validate([
            'name' => 'required',
            'number' => 'required|numeric',
            'city' => 'required',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'scale' => 'required|numeric',
            'number_of_rooms' => 'required|numeric',
            'description' => 'required',
            'rahn_amount' => [Rule::requiredIf($request->type_sale == 'rahn') , 'numeric'],
            'rent_amount' => [Rule::requiredIf($request->type_sale == 'rahn') , 'numeric'],
            'selling_price' => [Rule::requiredIf($request->type_sale == 'buy') , 'numeric'],
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'floor_number' => 'required|numeric',
            'is_star' => 'nullable',
            'expire_date' => 'required'
        ]);

//        $user = auth()->user();
        $customer->update([
            'name' => $request->name,
            'number' => $request->number,
            'city' => $request->city,
            'type_sale' => $request->type_sale,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'scale' => $request->scale,
            'number_of_rooms' => $request->number_of_rooms,
            'description' => $request->description,
            'rahn_amount' => $request->filled('rahn_amount') ? $request->rahn_amount : null,
            'rent_amount' => $request->filled('rent_amount') ? $request->rent_amount : null,
            'selling_price' => $request->filled('selling_price') ? $request->selling_price : null,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'floor' => $request->floor,
            'floor_number' => $request->floor_number,
//            'business_id' => $user->business()->id,
//            'user_id' => $user->id,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'expire_date' => Verta::parse($request->expire_date)->datetime()->format('Y-m-d')
        ]);
        return redirect()->route('customer.index',['status' => 'active']);
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->delete();

        return redirect()->back();
    }

    public function star(Customer $customer)
    {
        $this->authorize('update', $customer);

        if ($customer->is_star == 0) {
            $customer->is_star = 1;
            $customer->save();
        } else {
            $customer->is_star = 0;
            $customer->save();
        }
        return redirect()->back();
    }

}
