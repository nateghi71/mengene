<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Landowner;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory()->count(20)->create();
    }
}
