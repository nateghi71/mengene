<?php

namespace App\Policies;

use App\Models\User;

class UserManagementPolicy
{
    public function viewIndex(User $user): bool
    {
        return in_array('see_users',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function viewShow(User $user): bool
    {
        return in_array('see_show_user',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function create(User $user): bool
    {
        return in_array('create_user',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function edit(User $user): bool
    {
        return in_array('edit_user',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function changeStatus(User $user): bool
    {
        return in_array('change_status_user',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }
}
