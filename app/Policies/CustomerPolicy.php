<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->ownedBusiness()->exists() || $user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists();
    }

    public function view(User $user, Customer $customer)
    {
        return $user->ownedBusiness()->exists() || $user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists();
    }

    public function create(User $user)
    {
        return $user->ownedBusiness()->exists() || $user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists();
    }

    public function update(User $user, Customer $customer)
    {
        return $user->ownedBusiness()->exists() ||
            ($user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists() && $customer->user_id === $user->id);
    }

    public function delete(User $user, Customer $customer)
    {
        return $user->ownedBusiness()->exists() ||
            ($user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists() && $customer->user_id === $user->id);
    }
    public function star(User $user)
    {
        return $user->ownedBusiness()->exists() || $user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists();
    }

    public function viewSuggestion(User $user)
    {
        return $user->ownedBusiness()->exists() || $user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists();
    }

    public function reminder(User $user)
    {
        return $user->ownedBusiness()->exists() || $user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists();
    }
}
