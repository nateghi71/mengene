<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
                'name' => 'حسین',
                'email' => 'hooseinnateghi1401@gmail.com',
                'number' => '09356317466',
                'city_id' => 153,
                'password' => Hash::make(12345678),
            ]);

            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
        }

    }
}
