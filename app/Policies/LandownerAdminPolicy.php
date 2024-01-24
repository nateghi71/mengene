<?php

namespace App\Policies;

use App\Models\User;

trait LandownerAdminPolicy
{
    public function adminViewIndex(User $user): bool
    {
        return in_array('see_files',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function adminViewShow(User $user): bool
    {
        return in_array('see_show_file',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function adminCreate(User $user): bool
    {
        return in_array('create_file',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function adminEdit(User $user): bool
    {
        return in_array('edit_file',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }

    public function adminDelete(User $user): bool
    {
        return in_array('delete_file',$user->role->permissions->pluck('name')->toArray()) && !$user->isBanned();
    }
}
