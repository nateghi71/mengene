<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Landowner;
use App\Models\Premium;
use App\Models\Province;
use App\Models\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use http\Env\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\Business;
use App\Http\Controllers\API\MyBaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Business as BusinessResource;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use App\Models\UserCode;

class BusinessController extends Controller
{
    public function index()
    {
        $this->authorize('viewBusinessIndex' , Business::class);

        $user = auth()->user();
        $business = $user->ownedBusiness()->withCount('customers' , 'landowners')->first();

        return view('business.index', compact('business'));
    }
    public function showConsultants()
    {
        $this->authorize('viewBusinessIndex' , Business::class);

        $user = auth()->user();
        $business = $user->ownedBusiness()->first();

        if(request()->type === 'notAccepted')
        {
            $is_accepted = false;
            $members = $business->members()->wherePivot('is_accepted' , 0)->withCount('customers' , 'landowners')
                ->paginate(10)->withQueryString();
        }
        else
        {
            $is_accepted = true;
            $members = $business->members()->wherePivot('is_accepted' , 1)->withCount('customers' , 'landowners')
                ->paginate(10)->withQueryString();

            foreach ($members as $member) {
                $daysGone = Carbon::now()->diffInDays($member->getRawOriginal('joined_date')) + 1;
                $member->daysGone = $daysGone;
            }
        }

        return view('business.consultants', compact('members' , 'is_accepted'));
    }

    public function dashboard()
    {
        request()->session()->keep(['message']);
        $user = auth()->user();
        if($user->ownedBusiness()->exists())
            return redirect()->route('business.index');
        elseif ($user->joinedBusinesses()->exists())
            return redirect()->route('consultant.index');
        else
            return redirect()->route('business.create');
    }


    public function create(Request $request)
    {
        $provinces = Province::all();
        $this->authorize('createOrJoin', Business::class);
        return view('business.create' , compact('provinces'));
    }

    public
    function store(Request $request)
    {
        $this->authorize('createOrJoin', Business::class);

        $request->validate([
            'name' => 'required',
            'en_name' => 'required',
            'city_id' => 'required',
            'area' => 'required',
            'address' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = auth()->user();

        $imageName = '';
        if ($request->hasFile('image')) {
            $imageName = time() . $request->image->getClientOriginalName();
            $request->image->move(public_path(env('BUSINESS_IMAGES_UPLOAD_PATH')), $imageName);
        }

        try
        {
            DB::beginTransaction();
            $business = Business::create([
                'name' => $request->name,
                'en_name' => $request->en_name,
                'user_id' => $user->id,
                'image' => $imageName,
                'city_id' => $request->city_id,
                'area' => $request->area,
                'address' => $request->address
            ]);

            $premium = new PremiumController();
            $premium->store($business);

            DB::commit();
        }
        catch (\Exception $e)
        {
            dd($e->getMessage());
            DB::rollBack();
        }

        return redirect()->route('dashboard')->with('message' , 'املاکی موردنظر ایجاد شد.');
    }

    public function edit(Business $business)
    {
        $provinces = Province::all();
        $this->authorize('updateBusiness' , $business);
        return view('business.edit', compact('business' , 'provinces'));
    }

    public function update(Request $request, Business $business)
    {
        $this->authorize('updateBusiness' , $business);
        $request->validate([
            'name' => 'required',
            'en_name' => 'required',
            'city_id' => 'required',
            'area' => 'required',
            'address' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . $request->image->getClientOriginalName();
            $request->image->move(public_path(env('BUSINESS_IMAGES_UPLOAD_PATH')), $imageName);
        }

        $business->update([
            'name' => $request->name,
            'en_name' => $request->en_name,
            'image' => $request->hasFile('image') ? $imageName : $business->image,
            'city_id' => $request->city_id,
            'area' => $request->area,
            'address' => $request->address
        ]);

        return redirect()->route('dashboard')->with('message' , 'املاکی موردنظر اپدیت شد.');
    }

    public function destroy(Business $business)
    {
        $this->authorize('deleteBusiness', $business);

        if ($business->members()->exists()) {
            abort(403, 'قبل از لغو همکاری فرد دیگری را به عنوان مالک تعیین کنید');
        } else {
            $business->delete();
            return redirect()->route('dashboard');
        }
    }

    public function toggleUserAcceptance(User $user)
    {
        // Make sure the authenticated user is the owner of the business
        $business = $user->joinedBusinesses()->first();
        $this->authorize('toggleAcceptUser', $business);

        $userAuth = auth()->user();

        $member = $user->businessUser()->first();
        if ($member->is_accepted == 0) {

            $userAuth = auth()->user();
            if($userAuth->isFreeUser() || ($userAuth->isMidLevelUser() && $userAuth->getPremiumCountConsultants() > 4))
                return redirect()->back()->with('message', 'شما نمی توانید مشاور اضافه کنید.');
            $userAuth->incrementPremiumCountConsultants();
            $member->joined_date = Carbon::now()->format('Y-m-d');

            $member->is_accepted = 1;
            $member->save();
        } else {
            $userAuth->decrementPremiumCountConsultants();
            $member->is_accepted = 0;
            $member->save();
        }

        return redirect()->back()->with('message', 'تغییرات شما اعمال شد.');
    }

    public function chooseOwner(User $user)
    {
        // Make sure the authenticated user is the owner of the business
        $business = $user->joinedBusinesses()->first();
        $this->authorize('chooseOwner', $business);

        $userAuth = auth()->user();
        if($userAuth->isFreeUser() || ($userAuth->isMidLevelUser() && $userAuth->getPremiumCountConsultants() > 4))
            return redirect()->back()->with('message', 'شما نمی توانید مشاور اضافه کنید.');

        $business->members()->attach($userAuth);
        $member = $userAuth->businessUser()->first();
        $member->is_accepted = 1;
        $member->save();
        $business->members()->detach($user);
        $business->user_id = $user->id;
        $business->update();

        return redirect()->route('dashboard')->with('message', 'تغییرات شما اعمال شد.');
    }

    public function removeMember(User $user)
    {
        $business = $user->joinedBusinesses()->first();
        $this->authorize('removeMember', $business);

        $business->members()->detach($user);
        return redirect()->route('business.consultants')->with('success', 'مشاور مورد نظر با موفقیت حذف شد');
    }

}
