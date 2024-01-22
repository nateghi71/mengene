<?php

namespace App\Policies;

use App\Models\User;

trait FilePolicy
{
    public function viewIndex(User $user): bool
    {
        return in_array('see_files',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function viewShow(User $user): bool
    {
        return in_array('see_show_file',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function create(User $user): bool
    {
        return in_array('create_file',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function edit(User $user): bool
    {
        return in_array('edit_file',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function delete(User $user): bool
    {
        return in_array('delete_file',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }
}
