<?php

namespace App\Http\Controllers\web;

use App\Events\CreateCustomerFile;
use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\HelperClasses\UpdateStatusFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
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
        if ($customer->getRawOriginal('expire_date') > Carbon::now()) {
            $daysLeft = Carbon::now()->diffInDays($customer->getRawOriginal('expire_date')) + 1;
            $customer->daysLeft = $daysLeft;
        }

        return view('customer.show', compact('customer'));
    }

    public function create()
    {
        $provinces = Province::all();
        $this->authorize('create' , Customer::class);
        return view('customer.create', compact('provinces'));
    }

    public function store(CustomerRequest $request)
    {
        $this->authorize('create' , Customer::class);

        $user = auth()->user();
        $customer = Customer::create([
            'type_file' => 'business',
            'type_sale' => $request->type_sale,
            'access_level' => $request->access_level,
            'name' => $request->name,
            'number' => $request->number,
            'scale' => $request->scale,
            'city_id' => $request->city_id,
            'area' => $request->area,
            'expire_date' => $request->expire_date,
            'selling_price' => ($request->type_sale === 'buy' && $request->selling_price !== null) ? $request->selling_price : 0,
            'rahn_amount' => ($request->type_sale === 'rahn' && $request->rahn_amount !== null) ? $request->rahn_amount : 0,
            'rent_amount' => ($request->type_sale === 'rahn' && $request->rent_amount !== null) ? $request->rent_amount : 0,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'document' => $request->document,
            'address' => $request->address,
            'discharge' => $request->has('discharge') ? 1 : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'exist_owner' => $request->has('exist_owner') ? 1 : 0,
            //more
            'year_of_construction' => $request->year_of_construction,
            'year_of_reconstruction' => $request->year_of_reconstruction,
            'number_of_rooms' => $request->number_of_rooms,
            'floor_number' => ($request->type_build !== 'house' && $request->type_build !== 'land' && $request->floor_number !== null) ? $request->floor_number : 0,
            'floor' => ($request->type_build !== 'land' && $request->floor !== null) ? $request->floor : 0,
            'floor_covering' => $request->floor_covering,
            'cooling' => $request->cooling,
            'heating' => $request->heating,
            'cabinets' => $request->cabinets,
            'view' => $request->view,
            'description' => $request->description,
            'business_id' => $user->business()->id,
            'user_id' => $user->id,
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

    public function update(CustomerRequest $request, Customer $customer)
    {
        $this->authorize('update', $customer);

//        $user = auth()->user();
        $customer->update([
            'type_file' => 'business',
            'type_sale' => $request->type_sale,
            'access_level' => $request->access_level,
            'name' => $request->name,
            'number' => $request->number,
            'scale' => $request->scale,
            'city_id' => $request->city_id,
            'area' => $request->area,
            'expire_date' => $request->expire_date,
            'selling_price' => ($request->type_sale === 'buy' && $request->selling_price !== null) ? $request->selling_price : 0,
            'rahn_amount' => ($request->type_sale === 'rahn' && $request->rahn_amount !== null) ? $request->rahn_amount : 0,
            'rent_amount' => ($request->type_sale === 'rahn' && $request->rent_amount !== null) ? $request->rent_amount : 0,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'document' => $request->document,
            'address' => $request->address,
            'discharge' => $request->has('discharge') ? 1 : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'exist_owner' => $request->has('exist_owner') ? 1 : 0,
            //more
            'year_of_construction' => $request->year_of_construction,
            'year_of_reconstruction' => $request->year_of_reconstruction,
            'number_of_rooms' => $request->number_of_rooms,
            'floor_number' => ($request->type_build !== 'house' && $request->type_build !== 'land' && $request->floor_number !== null) ? $request->floor_number : 0,
            'floor' => ($request->type_build !== 'land' && $request->floor !== null) ? $request->floor : 0,
            'floor_covering' => $request->floor_covering,
            'cooling' => $request->cooling,
            'heating' => $request->heating,
            'cabinets' => $request->cabinets,
            'view' => $request->view,
            'description' => $request->description,
//            'business_id' => $user->business()->id,
//            'user_id' => $user->id,
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
        $this->authorize('star', Customer::class);

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

        $this->authorize('reminder', Customer::class);

        $user = auth()->user();
        if($user->isFreeUser() || $user->business()->wallet < 200)
            return back()->with('message' , 'شما به این امکانات دسترسی ندارید.');

        $customer = Customer::find($request->customer_id);
        $date = Verta::parse($request->remainder)->datetime()->format('Y-m-d H:i:s');
        $time = new Carbon($date);
        auth()->user()->notify((new ReminderForCustomerNotification($customer , $date))->delay($time));

        return back()->with('message' , 'یک هشدار برای شما اعمال شد.');
    }

}
