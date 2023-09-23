<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use App\Models\Business;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BusinessPolicy
{
    use HandlesAuthorization;


    public function update(User $user, Business $businessId)
    {
        return $businessId->user_id === $user->id
            ?
            Response::allow()
            : Response::deny('You do not own this business.');
    }

    public function create(User $user)
    {
        return !auth()->user()->isAssociatedWithBusiness()
            ?
            Response::allow()
            : Response::deny('You already have a business');
    }

}
