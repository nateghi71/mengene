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
use Illuminate\Support\Facades\Validator;

class ConsultantController extends Controller
{
    use MyBaseController;

    public function index()
    {
        try
        {
            $this->authorize('viewConsultantIndex', Business::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $user = auth()->user();
        $business = $user->joinedBusinesses()->first();
        $business->loadCount(['customers' , 'landowners']);

        return $this->sendResponse([
            'user' => $user,
            'business' => $business ? new BusinessResource($business) : [],
        ], 'Consultant retrieved successfully.');
    }

    public function search(Request $request)
    {
        try
        {
            $this->authorize('createOrJoin', Business::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $validator = Validator::make($request->all() , [
            'owner_number' => 'required|digits:11|iran_mobile'
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error', $validator->errors() , 400);
        }

        $ownerNumber = $request->input('owner_number');
        $business = Business::whereHas('owner', function ($query) use ($ownerNumber) {
            $query->where('number', $ownerNumber);
        })->first();

        if (!$business) {
            return $this->sendError('Logic Error', ['message' => 'No business found for the given number'] , 400);
        }

        return $this->sendResponse([
            'business' => $business ? new BusinessResource($business) : [],
        ], 'business retrieved successfully.');
    }

    public function join(Request $request)
    {
        try
        {
            $this->authorize('createOrJoin', Business::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $user = auth()->user();
        $business = Business::where('id', $request->business_id)->first();
        $owner = $business->owner()->first();
        $business->members()->attach($user);

        $owner->notify(new ConsultantRequestNotification($user));

        return $this->sendResponse([], 'Job Done successfully.');
    }

    public function leaveMember(User $user)
    {
        try
        {
            $this->authorize('leaveMember', Business::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $business = $user->joinedBusinesses()->first();
        $business->members()->detach($user);
        return $this->sendResponse([], 'Job Done successfully.');
    }
}
