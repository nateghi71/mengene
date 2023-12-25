<?php

namespace App\Policies;

use App\Models\Landowner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LandownerPolicy
{
    use HandlesAuthorization;

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
}
