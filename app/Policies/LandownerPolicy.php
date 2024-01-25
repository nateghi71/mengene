<?php

namespace App\Policies;

use App\Models\Landowner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LandownerPolicy
{
    use HandlesAuthorization , LandownerAdminPolicy;

    public function viewAny(User $user)
    {
        return $user->ownedBusiness()->exists() || $user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists();
    }

    public function view(User $user, Landowner $landowner)
    {
        return $user->ownedBusiness()->exists() || $user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists();
    }

    public function create(User $user)
    {
        return $user->ownedBusiness()->exists() || $user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists();
    }

    public function update(User $user, Landowner $landowner)
    {
        return $user->ownedBusiness()->exists() ||
            ($user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists() && $landowner->user_id === $user->id);
    }

    public function delete(User $user, Landowner $landowner)
    {
        return $user->ownedBusiness()->exists() ||
            ($user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists() && $landowner->user_id === $user->id);
    }

    public function star(User $user)
    {
        return $user->ownedBusiness()->exists() || $user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists();
    }
    public function reminder(User $user)
    {
        return $user->ownedBusiness()->exists() || $user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists();
    }

    public function viewSuggestion(User $user)
    {
        return $user->ownedBusiness()->exists() || $user->joinedBusinesses()->wherePivot('is_accepted', 1)->exists();
    }


    public function subscription(User $user)
    {
        return $user->ownedBusiness()->exists();
    }
}
