<?php

namespace Test\Models;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Timelog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase {

    use RefreshDatabase;

    public function test_service_has_correct_validation_rules() {
        // Validierungsregeln abrufen
        $rules = Service::validationRules();

        $this->assertEquals([
            'name'           => 'required|bail|string|max:255',
            'description'    => 'nullable|bail|string|max:999',
            'costs_per_hour' => 'required|bail|numeric',
        ], $rules);
    }

    public function test_service_belongs_to_many_contracts() {
        $service = Service::factory()->create();
        $contracts = Contract::factory()->count(2)->create();

        $service->contracts()->attach($contracts->pluck('id'), ['hours' => 6]);
        $this->assertCount(2, $service->contracts);
    }

    public function test_service_has_many_timelogs() {
        $customer = Customer::factory()->create();
        $contract = Contract::factory()->create();
        $service = Service::factory()->create();
        Timelog::factory()->count(5)->create([
            'customer_id' => $customer->id,
            'contract_id' => $contract->id,
            'service_id'  => $service->id,
        ]);

        $this->assertCount(5, $service->timelogs);
    }
}
