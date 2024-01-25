<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();
            $role = Role::where('name' , 'admin')->first();

            $role->users()->create([
                'name' => 'Admin',
                'email' => 'dariush.kianifar@gmail.com',
                'number' => '09358668218',
                'city_id' => 153,
                'password' => 'd8b0381388db8c27e839ee6ae3b5c2c2',
            ]);

            Auth::guard('web')->logout();

            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
    }
}
