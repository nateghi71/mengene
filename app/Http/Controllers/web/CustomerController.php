<?php

namespace App\Http\Controllers\web;

use App\Events\CreateCustomerFile;
use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\HelperClasses\UpdateStatusFile;
use App\Http\Controllers\Controller;
use App\Models\Landowner;
use App\Models\Province;
use App\Models\RandomLink;
use App\Models\User;
use App\Notifications\ReminderForCustomerNotification;
use Hekmatinasser\Verta\Facades\Verta;
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
    public function َََََindex()
    {
        $this->authorize('viewAny' , Customer::class);
        $user = auth()->user();

        $business = $user->business();

        $customers = $business->customers()->filter()->search()->paginate(10)->withQueryString();

        foreach ($customers as $customer) {
            if ($customer->getRawOriginal('expire_date') > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($customer->getRawOriginal('expire_date')) + 1;
                $customer->daysLeft = $daysLeft;
            }
        }

        return view('customer.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $this->authorize('view' , $customer);
        return view('customer.show', compact('customer'));
    }

    public function create()
    {
        $provinces = Province::all();
        $this->authorize('create' , Customer::class);
        return view('customer.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $this->authorize('create' , Customer::class);
        $request->validate([
            'name' => 'required',
            'number' => 'required|iran_mobile',
            'city_id' => 'required',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'scale' => 'required',
            'area' => 'required|numeric',
            'number_of_rooms' => 'required|numeric',
            'description' => 'required',
            'rahn_amount' => 'exclude_if:type_sale,buy|required',
            'rent_amount' => 'exclude_if:type_sale,buy|required',
            'selling_price' => 'exclude_if:type_sale,rahn|required',
            'access_level' => 'required',
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'floor' => 'exclude_if:type_build,house|required|numeric',
            'floor_number' => 'exclude_if:type_build,house|required|numeric',
            'is_star' => 'nullable',
            'expire_date' => 'required'
        ]);

        $user = auth()->user();
        $customer = Customer::create([
            'name' => $request->name,
            'number' => $request->number,
            'city_id' => $request->city_id,
            'type_sale' => $request->type_sale,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'type_file' => 'business',
            'scale' => $request->scale,
            'area' => $request->area,
            'number_of_rooms' => $request->number_of_rooms,
            'description' => $request->description,
            'access_level' => $request->access_level,
            'rahn_amount' => $request->type_sale === 'rahn' ? $request->rahn_amount : 0,
            'rent_amount' => $request->type_sale === 'rahn' ? $request->rent_amount : 0,
            'selling_price' => $request->type_sale === 'buy' ? $request->selling_price : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'floor' => $request->type_build === 'apartment' ? $request->floor : 0,
            'floor_number' => $request->type_build === 'apartment' ? $request->floor_number : 0,
            'business_id' => $user->business()->id,
            'user_id' => $user->id,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'expire_date' => $request->expire_date
        ]);

        event(new CreateCustomerFile($customer , $user));

        return redirect()->route('customer.index',['status' => 'active'])->with('message' , 'فایل موردنظر ایجاد شد.');
    }

    public function edit(Customer $customer)
    {
        $provinces = Province::all();
        $this->authorize('update', $customer);
        return view('customer.edit', compact('customer' , 'provinces'));
    }

    public function update(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        $request->validate([
            'name' => 'required',
            'number' => 'required|iran_mobile',
            'city_id' => 'required',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'scale' => 'required',
            'area' => 'required|numeric',
            'number_of_rooms' => 'required|numeric',
            'description' => 'required',
            'access_level' => 'required',
            'rahn_amount' => 'exclude_if:type_sale,buy|required',
            'rent_amount' => 'exclude_if:type_sale,buy|required',
            'selling_price' => 'exclude_if:type_sale,rahn|required',
            'elevator' => 'sometimes|nullable',
            'parking' => 'sometimes|nullable',
            'store' => 'sometimes|nullable',
            'floor' => 'exclude_if:type_build,house|required|numeric',
            'floor_number' => 'exclude_if:type_build,house|required|numeric',
            'is_star' => 'sometimes|nullable',
            'expire_date' => 'required'
        ]);
//        $user = auth()->user();
        $customer->update([
            'name' => $request->name,
            'number' => $request->number,
            'city_id' => $request->city_id,
            'type_sale' => $request->type_sale,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'scale' => $request->scale,
            'area' => $request->area,
            'number_of_rooms' => $request->number_of_rooms,
            'description' => $request->description,
            'access_level' => $request->access_level,
            'rahn_amount' => $request->type_sale === 'rahn' ? $request->rahn_amount : 0,
            'rent_amount' => $request->type_sale === 'rahn' ? $request->rent_amount : 0,
            'selling_price' => $request->type_sale === 'buy' ? $request->selling_price : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'floor' => $request->type_build === 'apartment' ? $request->floor : 0,
            'floor_number' => $request->type_build === 'apartment' ? $request->floor_number : 0,
//            'business_id' => $user->business()->id,
//            'user_id' => $user->id,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'expire_date' => $request->expire_date
        ]);
        return redirect()->route('customer.index',['status' => 'active'])->with('message' , 'فایل موردنظر اپدیت شد.');
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->delete();

        return redirect()->back()->with('message' , 'فایل موردنظر حذف شد.');;
    }

    public function star(Customer $customer)
    {
        $this->authorize('update', $customer);

        if ($customer->getRawOriginal('is_star') == 0) {
            $customer->is_star = 1;
            $customer->save();
        } else {
            $customer->is_star = 0;
            $customer->save();
        }
        return redirect()->back()->with('message' , 'جایگاه فایل موردنظر تغییر کرد.');
    }

    public function setRemainderTime(Request $request){
        $customer = Customer::find($request->customer_id);
        $date = Verta::parse($request->remainder)->datetime()->format('Y-m-d H:i:s');
        $time = new Carbon($date);
        auth()->user()->notify((new ReminderForCustomerNotification($customer , $date))->delay($time));

        return back()->with('message' , 'یک هشدار برای شما اعمال شد.');
    }

}
