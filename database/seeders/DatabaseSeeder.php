<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {

        User::create([
            'firstname' => 'Arnt',
            'lastname'  => 'Admin',
            'role'      => 'admin',
            'email'     => 'ad@min.de',
            'password'  => Hash::make('password'),
        ]);

        Contract::create([
            'name'          => '-',
            'monthly_costs' => 0,
            'flatrate'      => false,
        ]);

        $this->call([
            ContractSeeder::class,
            ServiceSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}
