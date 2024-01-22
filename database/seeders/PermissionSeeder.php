<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'see_users']);
        Permission::create(['name' => 'see_roles']);
        Permission::create(['name' => 'see_files']);
        Permission::create(['name' => 'see_businesses']);
        Permission::create(['name' => 'see_show_user']);
        Permission::create(['name' => 'see_show_role']);
        Permission::create(['name' => 'see_show_business']);
        Permission::create(['name' => 'see_show_file']);
        Permission::create(['name' => 'create_user']);
        Permission::create(['name' => 'create_role']);
        Permission::create(['name' => 'create_file']);
        Permission::create(['name' => 'edit_user']);
        Permission::create(['name' => 'edit_file']);
        Permission::create(['name' => 'edit_role']);
        Permission::create(['name' => 'change_status_business']);
        Permission::create(['name' => 'delete_file']);
        Permission::create(['name' => 'change_status_file']);
        Permission::create(['name' => 'delete_role']);
        Permission::create(['name' => 'change_status_user']);
        Permission::create(['name' => 'see_admin_panel']);
        Role::create(['name' => 'user']);
        $role = Role::create(['name' => 'admin']);
        $role->permissions()->sync(range(1, 20));
    }
}
