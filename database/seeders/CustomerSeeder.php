<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Timelog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Customer::factory()
            ->count(30)
            ->create()
            ->each(function($customer) {
                // Standardvertrag abfragen oder erstellen, falls nicht vorhanden
                $defaultContract = Contract::firstOrCreate([
                    'name' => '-',
                ], [
                    'monthly_costs' => 0,
                    'flatrate'      => false,
                ]);

                $customer->contracts()->attach($defaultContract->id, [
                    'start_date'  => now(),
                    'create_date' => now(),
                ]);

                $contracts = Contract::inRandomOrder()->take(rand(1,
                    3))->get();
                foreach($contracts as $contract){               // Hier werden 1 bis 3 zufällige Verträge ausgewählt
                    $startDate = now()->subMonths(rand(1, 36)); // Random Startdatum in den letzten 3 Jahren
                    $createDate = $startDate->subMonths(rand(0,
                        1));                                    // Random Create-Datum maximal 1 Monat vor Vertragsbeginn
                    $endDate = $startDate->copy()->addYear(rand(1, 3));

                    // Customer-Contract-Verknüpfung mit Pivot-Werten
                    $customer->contracts()->attach($contract->id, [
                        'start_date'  => $startDate,
                        'create_date' => $createDate,
                        'end_date'    => $endDate,
                    ]);

                    // Services für den Vertrag zuweisen, ohne Duplikate
                    $availableServices = Service::inRandomOrder()->take(rand(1, 5))->pluck('id')->toArray();
                    foreach($availableServices as $serviceId){
                        if( !$contract->services()->where('service_id', $serviceId)->exists()){
                            $contract->services()->attach($serviceId, [
                                'hours' => $contract->flatrate ? null : rand(1, 24),
                            ]);
                        }
                    }

                    // Timelogs erstellen
                    for($date = $startDate; $date <= $endDate; $date->addMonth()){
                        $timelog = new Timelog([
                            'customer_id' => $customer->id,
                            'contract_id' => $contract->id,
                            'service_id'  => $availableServices[array_rand($availableServices)],
                            // zufälligen Service auswählen
                            'date'        => $date->copy(),
                            'hours'       => rand(1, 24),
                        ]);
                        $timelog->save();
                    }
                }
            });
    }
}
