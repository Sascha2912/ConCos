<?php

namespace Database\Seeders;

use App\Models\Timelog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimelogSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Timelog::factory(20)->create();
    }
}
