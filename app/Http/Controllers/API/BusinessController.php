<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\MyBaseController as BaseController;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\UserResource;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Landowner;
use App\Models\Premium;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PHPUnit\Exception;

class BusinessController extends BaseController
{
    public function index()
    {
        try
        {
            $this->authorize('viewBusinessIndex' , Business::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $user = auth()->user();
        $business = $user->ownedBusiness()->withCount('customers' , 'landowners')->first();

        return $this->sendResponse([
            'user' => $user,
            'business' => new BusinessResource($business),
        ],'business retrieved successfully.');
    }

    public function showAcceptedConsultants()
    {
        try
        {
            $this->authorize('viewBusinessIndex' , Business::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $user = auth()->user();
        $business = $user->ownedBusiness()->first();

        $acceptedMembers = $business->members()->wherePivot('is_accepted' , 1)->withCount('customers' , 'landowners')
            ->paginate(10)->withQueryString();

        return $this->sendResponse([
            'acceptedMembers' => $acceptedMembers ? UserResource::collection($acceptedMembers) : [],
            'links' => $acceptedMembers ? UserResource::collection($acceptedMembers)->response()->getData()->links : [],
            'meta' => $acceptedMembers ? UserResource::collection($acceptedMembers)->response()->getData()->meta : [],

        ], 'Members Accepted retrieved successfully.');
    }
    public function showNotAcceptedConsultants()
    {
        try
        {
            $this->authorize('viewBusinessIndex' , Business::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $user = auth()->user();
        $business = $user->ownedBusiness()->first();

        $notAcceptedMembers = $business->members()->wherePivot('is_accepted' , 0)->withCount('customers' , 'landowners')
            ->paginate(10)->withQueryString();

        return $this->sendResponse([
            'notAcceptedMembers' => $notAcceptedMembers ? UserResource::collection($notAcceptedMembers) : [],
            'links' => $notAcceptedMembers ? UserResource::collection($notAcceptedMembers)->response()->getData()->links : [],
            'meta' => $notAcceptedMembers ? UserResource::collection($notAcceptedMembers)->response()->getData()->meta : [],

        ], 'Members NotAccepted retrieved successfully.');
    }


    public function store(Request $request)
    {
        try
        {
            $this->authorize('createOrJoin' , Business::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'city_id' => 'required',
            'area' => 'required',
            'address' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error', $validator->errors() , 400);
        }

        try{
            DB::beginTransaction();

            $user = auth()->user();
            $imageName = '';
            if ($request->hasFile('image')) {
                $imageName = generateFileName($request->image->getClientOriginalName());
                $request->image->move(public_path(env('BUSINESS_IMAGES_UPLOAD_PATH')), $imageName);
            }

            $business = Business::create([
                'name' => $request->name,
                'user_id' => $user->id,
                'image' => $imageName,
                'city_id' => $request->city_id,
                'area' => $request->area,
                'address' => $request->address,
                'wallet' => 0,
            ]);

            $premium = new PremiumController();
            $premium->store($business);
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->sendError('Database Error', $e->getMessage() , 500);
        }

        return $this->sendResponse([
            'business' => $business ? new BusinessResource($business) : [],
        ], 'business created successfully.');
    }

    public function update(Request $request, Business $business)
    {
        try
        {
            $this->authorize('updateBusiness' , $business);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $validator = Validator::make($request->all() , [
            'name' => 'required',
            'city_id' => 'required',
            'area' => 'required',
            'address' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error', $validator->errors() , 400);
        }

        $imageName = null;
        if ($request->hasFile('image')) {
            if(File::exists(public_path(env('BUSINESS_IMAGES_UPLOAD_PATH')).$business->image)){
                File::delete(public_path(env('BUSINESS_IMAGES_UPLOAD_PATH')).$business->image);
            }

            $imageName = time() . $request->image->getClientOriginalName();
            $request->image->move(public_path(env('BUSINESS_IMAGES_UPLOAD_PATH')), $imageName);
        }

        $business->update([
            'name' => $request->name,
            'image' => $request->hasFile('image') ? $imageName : $business->image,
            'city_id' => $request->city_id,
            'area' => $request->area,
            'address' => $request->address
        ]);

        return $this->sendResponse([
            'business' => $business ? new BusinessResource($business) : [],
        ], 'business updated successfully.');
    }

    public function destroy(Business $business)
    {
        try
        {
            $this->authorize('deleteBusiness' , $business);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        if ($business->members()->exists()) {
            return $this->sendError('Logic Error', ['message' => 'قبل از لغو همکاری فرد دیگری را به عنوان مالک تعیین کنید'] , 500);
        } else {
            $business->delete();
            return $this->sendResponse([], 'business destroy successfully.');
        }
    }

    public function toggleUserAcceptance(User $user)
    {
        $business = $user->joinedBusinesses()->first();
        try
        {
            $this->authorize('toggleAcceptUser' , $business);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $userAuth = auth()->user();

        $member = $user->businessUser()->first();
        if ($member->is_accepted == 0) {

            $userAuth = auth()->user();
            if($userAuth->isFreeUser()
                || ($userAuth->isBronzeUser() && $userAuth->getPremiumCountConsultants() > 2)
                || ($userAuth->isSilverUser() && $userAuth->getPremiumCountConsultants() > 3))
                return $this->sendError('Logic Error', ['message' => 'شما نمی توانید مشاور اضافه کنید.'] , 500);

            $userAuth->incrementPremiumCountConsultants();
            $member->joined_date = Carbon::now()->format('Y-m-d');
            $member->is_accepted = 1;
            $member->save();
        } else {
            $userAuth->decrementPremiumCountConsultants();
            $member->is_accepted = 0;
            $member->save();
        }

        return $this->sendResponse([], 'Job Done successfully.');
    }


    public function chooseOwner(User $user)
    {
        $business = $user->joinedBusinesses()->first();
        try
        {
            $this->authorize('chooseOwner' , $business);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $userAuth = auth()->user();
        if($userAuth->isFreeUser()
            || ($userAuth->isBronzeUser() && $userAuth->getPremiumCountConsultants() > 2)
            || ($userAuth->isSilverUser() && $userAuth->getPremiumCountConsultants() > 3))
            return redirect()->back()->with('message', 'شما نمی توانید مشاور اضافه کنید.');

        $business->members()->attach($userAuth);
        $member = $userAuth->businessUser()->first();
        $member->is_accepted = 1;
        $member->save();
        $business->members()->detach($user);
        $business->user_id = $user->id;
        $business->update();

        return $this->sendResponse([], 'new business selected successfully.');
    }

    public function removeMember(User $user)
    {
        $business = $user->joinedBusinesses()->first();

        try
        {
            $this->authorize('removeMember', $business);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $business->members()->detach($user);
        return $this->sendResponse([], 'Member removed successfully.');
    }
}
