<?php

namespace Test\Models;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContractTest extends TestCase {

    use RefreshDatabase;

    public function test_contract_has_correct_validation_rules() {
        // Validierungsregeln abrufen
        $rules = Contract::validationRules();

        $this->assertEquals([
            'name'          => 'required|bail|string|max:255',
            'monthly_costs' => 'nullable|numeric',
            'flatrate'      => 'nullable|boolean',
        ], $rules);
    }

    public function test_contract_belongs_to_many_customers() {
        $contract = Contract::factory()->create();
        $customers = Customer::factory()->count(2)->create();

        $contract->customers()->attach($customers->pluck('id'), ['start_date' => now(), 'create_date' => now(),]);
        $this->assertCount(2, $contract->customers);
    }

    public function test_contract_belongs_to_many_services() {
        $contract = Contract::factory()->create();
        $services = Service::factory()->count(3)->create();

        $contract->services()->attach($services->pluck('id'), ['hours' => 6]);
        $this->assertCount(3, $contract->services);
    }
}
