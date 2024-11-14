<?php

namespace Test\Models;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Timelog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase {

    use RefreshDatabase;

    public function test_customer_has_correct_validation_rules_for_creation() {
        // Regeln für die Erstellung eines neuen Kunden (mit $creating=true)
        $rules = Customer::validationRules(true);

        $this->assertEquals([
            'name'              => 'required|bail|string|max:255',
            'managing_director' => 'required|bail|string|max:255',
            'phone'             => 'nullable|string|max:255',
            'email'             => 'required|bail|email|unique:users,email|string|max:255',
            'street'            => 'nullable|string|max:255',
            'house_number'      => 'nullable|string|max:255',
            'zip_code'          => 'nullable|string|max:255',
            'city'              => 'nullable|string|max:255',
        ], $rules);
    }

    public function test_customer_has_correct_validation_rules_for_updating() {
        // Regeln für die Aktualisierung eines bestehenden Kunden (mit $creating=false)
        $rules = Customer::validationRules(false);

        $this->assertEquals([
            'name'              => 'required|bail|string|max:255',
            'managing_director' => 'required|bail|string|max:255',
            'phone'             => 'nullable|string|max:255',
            'email'             => 'email|unique:users,email|string|max:255',
            'street'            => 'nullable|string|max:255',
            'house_number'      => 'nullable|string|max:255',
            'zip_code'          => 'nullable|string|max:255',
            'city'              => 'nullable|string|max:255',
        ], $rules);
    }

    public function test_customer_has_many_timelogs() {
        $customer = Customer::factory()->create();
        $contract = Contract::factory()->create();
        $service = Service::factory()->create();
        Timelog::factory()->count(3)->create([
            'customer_id' => $customer->id,
            'contract_id' => $contract->id,
            'service_id'  => $service->id,
            'date'        => now(),
            'hours'       => 8,
        ]);

        $this->assertCount(3, $customer->timelogs);
    }

    public function test_customer_belongs_to_many_contracts() {
        $customer = Customer::factory()->create();
        $contracts = Contract::factory()->count(2)->create();

        $customer->contracts()->attach($contracts->pluck('id'), ['start_date' => now(), 'create_date' => now(),]);
        $this->assertCount(2, $customer->contracts);
    }
}
