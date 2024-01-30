<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessPolicy
{
    use HandlesAuthorization , BusinessAdminPolicy;

    public function viewBusinessIndex(User $user)
    {
        return $user->ownedBusiness()->exists();
    }

    public function createOrJoin(User $user)
    {
        return !$user->ownedBusiness()->exists() && !$user->joinedBusinesses()->exists();
    }

    public function updateBusiness(User $user, Business $business)
    {
        return $user->ownedBusiness()->exists() && $business->user_id === $user->id;
    }

    public function deleteBusiness(User $user, Business $business)
    {
        return $user->ownedBusiness()->exists() && $business->user_id === $user->id;
    }

    public function toggleAcceptUser(User $user, Business $business)
    {
        return $user->ownedBusiness()->exists() && $business->user_id === $user->id;
    }

    public function chooseOwner(User $user, Business $business)
    {
        return $user->ownedBusiness()->exists() && $business->user_id === $user->id;
    }

    public function removeMember(User $user, Business $business)
    {
        return $user->ownedBusiness()->exists() && $business->user_id === $user->id;
    }

    public function leaveMember(User $user)
    {
        return $user->joinedBusinesses()->exists();
    }

    public function viewConsultantIndex(User $user)
    {
        return $user->joinedBusinesses()->exists();
    }

    public function isOwner(User $user)
    {
        return $user->ownedBusiness()->exists();
    }

}
