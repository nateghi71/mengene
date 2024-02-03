<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::create([
            'name' => 'free',
            'price' => 0,
            'time' => 12,
        ]);
        Package::create([
            'name' => 'bronze',
            'price' => 599000,
            'time' => 3,
        ]);
        Package::create([
            'name' => 'silver',
            'price' => 999000,
            'time' => 6,
        ]);
        Package::create([
            'name' => 'golden',
            'price' => 1199000,
            'time' => 12,
        ]);
    }
}
