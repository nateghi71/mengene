<?php

namespace App\Policies;

use App\Models\User;

class FilePolicy
{
    public function viewIndex(User $user): bool
    {
        return in_array('see_files',$user->role->permissions->pluck('name')->toArray());
    }

    public function viewShow(User $user): bool
    {
        return in_array('see_show_file',$user->role->permissions->pluck('name')->toArray());
    }

    public function create(User $user): bool
    {
        return in_array('create_file',$user->role->permissions->pluck('name')->toArray());
    }

    public function edit(User $user): bool
    {
        return in_array('edit_file',$user->role->permissions->pluck('name')->toArray());
    }

    public function delete(User $user): bool
    {
        return in_array('delete_file',$user->role->permissions->pluck('name')->toArray());
    }

    public function changeStatus(User $user): bool
    {
        return in_array('change_status_file',$user->role->permissions->pluck('name')->toArray());
    }
}
