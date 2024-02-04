<?php

namespace App\Policies;

use App\Models\User;

class OrderPolicy
{
    public function viewIndex(User $user): bool
    {
        return in_array('see_orders',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function viewShow(User $user): bool
    {
        return in_array('see_show_order',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function create(User $user): bool
    {
        return in_array('create_order',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function edit(User $user): bool
    {
        return in_array('edit_order',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function delete(User $user): bool
    {
        return in_array('delete_order',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }
}
