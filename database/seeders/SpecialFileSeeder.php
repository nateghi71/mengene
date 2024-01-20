<?php

namespace Database\Seeders;

use App\Models\SpecialFile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SpecialFile::factory()->count(20)->create();
    }
}
