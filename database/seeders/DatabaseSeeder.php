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

        $customers = Customer::factory(10)->create();
        $contracts = Contract::factory(5)->create();
        $services = Service::factory(10)->create();

        // Kunden den Verträgen zuweisen mit zufälligen `start_date` und `end_date`
        $customers->each(function($customer) use ($contracts, $services) {
            // Für jeden Kunden zufällig Verträge auswählen und anfügen
            $selectedContracts = $contracts->random(rand(1, 3));

            foreach($selectedContracts as $contract){
                // Kunden den Vertrag zuweisen
                $customer->contracts()->attach(
                    $contract->id,
                    [
                        'start_date'  => $this->randomStartDate(),
                        'end_date'    => $this->randomEndDate(), // Optional
                        'create_date' => $this->randomStartDate(),
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ],
                );

                // Speichere bereits zugewiesene Service-IDs
                $assignedServices = [];

                // Zufällige Services zu jedem Vertrag hinzufügen
                $numServices = rand(1, min(3, $services->count())); // Maximal 3 oder weniger, je nach Verfügbarkeit
                $selectedServices = $services->random($numServices);

                foreach($selectedServices as $service){
                    // Stelle sicher, dass der Service noch nicht zugewiesen wurde
                    if( !in_array($service->id, $assignedServices)){
                        // Überprüfe, ob die Kombination bereits existiert
                        if( !$contract->services()->where('service_id', $service->id)->exists()){
                            $contract->services()->attach($service->id, [
                                'hours'      => rand(10, 100), // Zufällige Stunden pro Service
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                            // Füge den Service zur Liste der zugewiesenen Services hinzu
                            $assignedServices[] = $service->id;
                        }
                    }
                }
            }
        });

        $this->call([
            UserSeeder::class,
            TimelogSeeder::class,
        ]);
    }

    // Funktion für zufälliges `start_date`
    private function randomStartDate() {
        // Zufälliges Datum innerhalb der letzten 5 Jahre
        return Carbon::now()->subDays(rand(0, 1825));
    }

    // Funktion für zufälliges `end_date`
    private function randomEndDate() {
        // Zufälliges Datum nach `start_date`, maximal 5 Jahre später
        $startDate = $this->randomStartDate();

        return rand(0, 1) ? $startDate->copy()->addDays(rand(30, 1825)) : null; // Optional null
    }
}
