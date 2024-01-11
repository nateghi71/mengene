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
        Permission::create(['name' => 'see_users' , 'guard_name' => 'web']);
        Permission::create(['name' => 'see_businesses' , 'guard_name' => 'web']);
        Permission::create(['name' => 'create_users' , 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_user' , 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_user' , 'guard_name' => 'web']);
        Permission::create(['name' => 'access_to_site' , 'guard_name' => 'web']);
    }
}
