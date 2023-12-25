<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Landowner;
use Illuminate\Database\Seeder;

class LandownerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Landowner::factory()->count(20)->create();
    }
}
