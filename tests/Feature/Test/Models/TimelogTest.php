<?php

namespace Test\Models;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Timelog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimelogTest extends TestCase {

    use RefreshDatabase;

    public function test_timelog_has_correct_validation_rules() {
        // Validierungsregeln abrufen
        $rules = Timelog::validationRules();

        $this->assertEquals([
            'customer_id' => 'required|integer|exists:customers,id',
            'service_id'  => 'required|integer|exists:services,id',
            'contract_id' => 'required|integer|exists:contracts,id',
            'hours'       => 'required|integer|between:1,24',
            'date'        => 'required|date',
            'description' => 'nullable|string|max:255',
        ], $rules);
    }

    public function test_timelog_belongs_to_customer_to_contract_to_service() {
        $customer = Customer::factory()->create();
        $contract = Contract::factory()->create();
        $service = Service::factory()->create();
        $timelog = Timelog::factory()->create([
            'customer_id' => $customer->id,
            'contract_id' => $contract->id,
            'service_id'  => $service->id,
            'date'        => now(),
            'hours'       => 8,
        ]);

        $this->assertEquals($customer->id, $timelog->customer->id);
        $this->assertEquals($contract->id, $timelog->contract->id);
        $this->assertEquals($service->id, $timelog->service->id);
    }
}
