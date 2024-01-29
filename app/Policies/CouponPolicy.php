<?php

namespace App\Policies;

use App\Models\User;

class CouponPolicy
{
    public function viewIndex(User $user): bool
    {
        return in_array('see_coupons',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function viewShow(User $user): bool
    {
        return in_array('see_show_coupon',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function create(User $user): bool
    {
        return in_array('create_coupon',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function edit(User $user): bool
    {
        return in_array('edit_coupon',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function delete(User $user): bool
    {
        return in_array('delete_coupon',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }
}
