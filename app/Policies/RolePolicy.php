<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    public function viewIndex(User $user): bool
    {
        return in_array('see_roles',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function viewShow(User $user): bool
    {
        return in_array('see_show_role',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function create(User $user): bool
    {
        return in_array('create_role',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function edit(User $user): bool
    {
        return in_array('edit_role',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function delete(User $user): bool
    {
        return in_array('delete_role',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }
}
