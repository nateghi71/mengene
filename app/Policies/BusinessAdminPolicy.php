<?php

namespace App\Policies;

use App\Models\User;

trait BusinessAdminPolicy
{
    public function viewIndex(User $user): bool
    {
        return in_array('see_businesses',$user->role->permissions->pluck('name')->toArray());
    }

    public function viewShow(User $user): bool
    {
        return in_array('see_show_business',$user->role->permissions->pluck('name')->toArray());
    }

    public function changeStatus(User $user): bool
    {
        return in_array('change_status_business',$user->role->permissions->pluck('name')->toArray());
    }
}
