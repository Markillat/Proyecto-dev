<?php

namespace Database\Seeders;

use App\Models\Workstation;
use Illuminate\Database\Seeder;

class WorkStationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Workstation::factory()->count(30)->create();
    }
}
