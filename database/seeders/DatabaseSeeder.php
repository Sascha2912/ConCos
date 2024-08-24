<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        $customers = Customer::factory(10)->create();
        $contracts = Contract::factory(5)->create();
        $services = Service::factory(10)->create();

        $contracts->each(function($contract) use ($customers) {
            $contract->customers()->attach($customers->random(2));
        });


        $contracts->each(function($contract) use ($services) {
            $contract->services()->attach($services->random(3));
        });

        $this->call([
            UserSeeder::class,
            TimelogSeeder::class,
        ]);
    }
}
