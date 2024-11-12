<?php

namespace Test\Http\Controllers;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Timelog;
use App\Models\User;
use App\Repositories\TimelogRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TimelogControllerTest extends TestCase {
    use RefreshDatabase;

    protected TimelogRepository $timelogRepository;

    protected function setUp(): void {
        parent::setUp();

        $this->timelogRepository = $this->app->make(TimelogRepository::class);
        $this->actingAs(User::factory()->create(['role' => 'admin']));
    }

    // ########## Tests for index ##########
    public function test_displays_customer_timelogs_index() {
        $customer = Customer::factory()->create();
        $contract = Contract::factory()->create();
        $service = Service::factory()->create();

        $customer->contracts()->attach($contract->id, [
            'create_date' => now()->subMonth(),
            'start_date'  => now(),
            'end_date'    => now()->addYear(),
        ]);

        Timelog::factory()->for($customer)->for($contract)->for($service)->count(3)->create();

        $response = $this->get(route('customers.timelogs.index', $customer->id));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('timelogs.index');
        $response->assertViewHas('timelogs');
        $response->assertViewHas('customer', $customer);
    }

    // ########## Tests for create ##########
    public function test_display_customer_timelog_create_form_with_contracts_and_services() {
        $customer = Customer::factory()->create();
        $contract = Contract::factory()->create();
        Service::factory()->count(5)->create();

        $customer->contracts()->attach($contract->id, [
            'create_date' => now()->subMonth(),
            'start_date'  => now(),
            'end_date'    => now()->addYear(),
        ]);

        $response = $this->get(route('customers.timelogs.create', $customer->id));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('timelogs.create');
        $response->assertViewHas('customer', $customer);
        $response->assertViewHas('contracts');
        $response->assertViewHas('services');
    }

    // ########## Tests store ##########
    public function test_store_new_customer_timelog_with_contracts_and_services_data() {
        $customer = Customer::factory()->create();
        $contract = Contract::factory()->create();
        $service = Service::factory()->create();

        $customer->contracts()->attach($contract->id, [
            'create_date' => now()->subMonth(),
            'start_date'  => now(),
            'end_date'    => now()->addYear(),
        ]);

        $data = [
            'customer_id' => $customer->id,
            'contract_id' => $contract->id,
            'service_id'  => $service->id,
            'hours'       => 5,
            'date'        => now()->format('Y-m-d'),
            'description' => 'Test description',
        ];

        $response = $this->post(route('customers.timelogs.store', $customer->id), $data);

        $this->assertDatabaseHas('timelogs', [
            'customer_id' => $data['customer_id'],
            'contract_id' => $data['contract_id'],
            'service_id'  => $data['service_id'],
            'hours'       => $data['hours'],
            'date'        => $data['date'],
            'description' => $data['description'],
        ]);

        $response->assertRedirect(route('timelogs.edit', ['timelog' => Timelog::latest()->first()->id]));
    }

    // ########## Tests for show ##########
    public function test_show_customer_timelog_details_with_contracts_and_services() {
        $customer = Customer::factory()->create();
        $contract = Contract::factory()->create();
        $service = Service::factory()->create();

        $customer->contracts()->attach($contract->id, [
            'create_date' => now()->subMonth(),
            'start_date'  => now(),
            'end_date'    => now()->addYear(),
        ]);

        $timelog = Timelog::factory()->for($customer)->for($contract)->for($service)->create();

        $response = $this->get(route('timelogs.show', $timelog->id));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('timelogs.show');
        $response->assertViewHas('timelog', $timelog);
        $response->assertViewHas('customer', $customer);
        $response->assertViewHas('contracts');
        $response->assertViewHas('services');
    }

    // ########## Tests for edit ##########
    public function test_displays_customer_timelog_edit_form_with_contracts_and_services() {
        $customer = Customer::factory()->create();
        $contract = Contract::factory()->create();
        $service = Service::factory()->create();

        $customer->contracts()->attach($contract->id, [
            'create_date' => now()->subMonth(),
            'start_date'  => now(),
            'end_date'    => now()->addYear(),
        ]);

        $timelog = Timelog::factory()->for($customer)->for($contract)->for($service)->create();

        $response = $this->get(route('timelogs.edit', $timelog->id));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('timelogs.edit');
        $response->assertViewHas('timelog', $timelog);
        $response->assertViewHas('customer', $customer);
        $response->assertViewHas('contracts');
        $response->assertViewHas('services');
        $response->assertViewHas('serviceContractMap');
    }

    // ########## Tests for update ##########
    public function test_update_customer_timelog_with_data() {
        $customer = Customer::factory()->create();
        $contract = Contract::factory()->create();
        $service = Service::factory()->create();

        $timelog = Timelog::factory()->create([
            'customer_id' => $customer->id,
            'contract_id' => $contract->id,
            'service_id'  => $service->id,
            'hours'       => 20,
            'date'        => now()->subYear(),
            'description' => 'Old description',
        ]);

        $newData = [
            'customer_id' => $customer->id,
            'contract_id' => $contract->id,
            'service_id'  => $service->id,
            'hours'       => 10,
            'date'        => now()->toDateString(),
            'description' => 'Updated description',
        ];

        $response = $this->patch(route('timelogs.update', $timelog), $newData);

        $response->assertRedirect(route('timelogs.edit', ['timelog' => $timelog->id]));
        $this->assertDatabaseHas('timelogs', [
            'id'          => $timelog->id,
            'customer_id' => $customer->id,
            'contract_id' => $contract->id,
            'service_id'  => $service->id,
            'hours'       => 10,
            'description' => 'Updated description',
        ]);

    }

    // ########## Tests for destroy ##########
    public function test_deletes_customer_timelog() {
        $customer = Customer::factory()->create();
        $contract = Contract::factory()->create();
        $service = Service::factory()->create();

        $customer->contracts()->attach($contract->id, [
            'create_date' => now()->subMonth(),
            'start_date'  => now(),
            'end_date'    => now()->addYear(),
        ]);

        $timelog = Timelog::factory()->for($customer)->for($contract)->for($service)->create();

        $response = $this->delete(route('timelogs.destroy', $timelog->id));

        $this->assertDatabaseMissing('timelogs', ['id' => $timelog->id]);
        $response->assertRedirect(route('customers.timelogs.index', $customer->id));
    }
}
