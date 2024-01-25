<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\MyBaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use App\Models\User;
use App\Notifications\ConsultantRequestNotification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ConsultantController extends BaseController
{
    public function index()
    {
        try
        {
            $this->authorize('viewConsultantIndex', Business::class);
        }
        catch (AuthorizationException $exception)
        {
            return response()->json(['message' => 'you join or have a business']);
        }

        $user = auth()->user();
        $business = $user->joinedBusinesses()->first();
        $business->loadCount(['customers' , 'landowners']);
        return response()->json([
            'user' => $user,
            'business' => new BusinessResource($business),
        ]);
    }

    public function search(Request $request)
    {
        try
        {
            $this->authorize('createOrJoin', Business::class);
        }
        catch (AuthorizationException $exception)
        {
            return response()->json(['message' => 'you join or have a business']);
        }

        $request->validate([
            'owner_number' => 'required|max:11|digits:11'
        ]);

        $ownerNumber = $request->input('owner_number');
        $business = Business::whereHas('owner', function ($query) use ($ownerNumber) {
            $query->where('number', $ownerNumber);
        })->first();

        if (!$business) {
            return response()->json(['message' => 'No business found for the given owner number'], 404);
        }
        return new BusinessResource($business);
    }

    public function join(Request $request)
    {
        try
        {
            $this->authorize('createOrJoin', Business::class);
        }
        catch (AuthorizationException $exception)
        {
            return response()->json(['message' => 'you join or have a business']);
        }

        $user = auth()->user();
        $business = Business::where('id', $request->business_id)->first();
        $owner = $business->owner()->first();
        $business->members()->attach($user);

        $owner->notify(new ConsultantRequestNotification($user));

        return response()->json(['message' => 'درخواست شما ثبت شد و منتظر تایید مالک است']);
    }

    public function leaveMember(User $user)
    {
        try
        {
            $this->authorize('leaveMember', Business::class);
        }
        catch (AuthorizationException $exception)
        {
            return response()->json(['message' => 'شما بیزینسی ندارید']);
        }

        $business = $user->joinedBusinesses()->first();
        $business->members()->detach($user);
        return response()->json(['message' => 'شما با موفقیت از بیزینس انصراف دادید']);
    }

}
