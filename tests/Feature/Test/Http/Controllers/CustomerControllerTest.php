<?php

namespace Test\Http\Controllers;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\User;
use App\Repositories\CustomerRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CustomerControllerTest extends TestCase {
    use RefreshDatabase;

    protected CustomerRepository $customerRepository;

    protected function setUp(): void {
        parent::setUp();

        $this->customerRepository = $this->app->make(CustomerRepository::class);
        $this->actingAs(User::factory()->create(['role' => 'admin']));
    }

    // ########## Tests for index ##########
    public function test_displays_customers_index() {
        Customer::factory()->count(15)->create();

        $response = $this->get(route('customers.index'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('customers.index');
        $response->assertViewHas('customers');
    }

    // ########## Tests for create ##########
    public function test_display_customer_create_form_with_contracts() {
        Contract::factory()->count(5)->create();

        $response = $this->get(route('customers.create'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('customers.create');
        $response->assertViewHas('contracts');
    }

    // ########## Tests store ##########
    public function test_store_new_customer_with_contracts_data() {
        // Definiere die Kundendaten
        $customerData = [
            'name'              => 'Test Customer',
            'managing_director' => 'John Doe',
            'phone'             => '123456789',
            'email'             => 'test@example.com',
            'street'            => 'Test Street',
            'house_number'      => '1',
            'city'              => 'Test City',
            'zip_code'          => '12345',
        ];

        // Erstelle einen Vertrag und Vertragsdaten
        $contract = Contract::factory()->create();

        // Strukturierte Daten wie erwartet für die `store`-Methode zusammenstellen
        $requestData = [
            'name'              => $customerData['name'],
            'managing_director' => $customerData['managing_director'],
            'phone'             => $customerData['phone'],
            'email'             => $customerData['email'],
            'street'            => $customerData['street'],
            'house_number'      => $customerData['house_number'],
            'city'              => $customerData['city'],
            'zip_code'          => $customerData['zip_code'],
            'contracts'         => [
                ['id' => $contract->id],
            ],
            'contract_dates'    => [
                $contract->id => [
                    'start_date'  => '2024-01-01',
                    'end_date'    => '2026-01-01',
                    'create_date' => '2024-01-01',
                ],
            ],
        ];

        // Anfrage senden und die Verarbeitung überprüfen
        $response = $this->post(route('customers.store'), $requestData);

        // Bestätige die Umleitung nach dem Erstellen
        $response->assertRedirect();

        // Verifiziere, dass der Kunde in der Datenbank ist
        $this->assertDatabaseHas('customers', [
            'name' => $customerData['name'],
        ]);

        // Verifiziere, dass die Pivot-Tabelle die Vertragsdaten korrekt enthält
        $this->assertDatabaseHas('contract_customer', [
            'contract_id' => $contract->id,
            'start_date'  => '2024-01-01',
            'end_date'    => '2026-01-01',
            'create_date' => '2024-01-01',
        ]);
    }

    // ########## Tests for show ##########
    public function test_show_customer_details_with_contracts() {
        $customer = Customer::factory()->create();
        $contract = Contract::factory()->create();
        $customer->contracts()->attach($contract->id, [
            'start_date'  => '2024-01-01',
            'end_date'    => '2026-01-01',
            'create_date' => '2024-01-01',
        ]);

        $response = $this->get(route('customers.show', $customer));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('customers.show');
        $response->assertViewHas('customer');
        $response->assertViewHas('contracts');
    }

    // ########## Tests for edit ##########
    public function test_displays_customer_edit_form_with_customer_and_contracts() {
        $customer = Customer::factory()->create();
        $contracts = Contract::factory()->count(3)->create();
        $customer->contracts()->attach($contracts, [
            'start_date'  => Carbon::now(),
            'create_date' => Carbon::now(),
        ]);

        $response = $this->get(route('customers.edit', $customer));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('customers.edit');
        $response->assertViewHas('customer');
        $response->assertViewHas('contracts');
    }

    // ########## Tests for update ##########
    public function test_update_customer_with_contract_data() {
        $customer = Customer::factory()->create([
            'name'  => 'Old name',
            'email' => 'oldemail@example.com',
        ]);
        $contract = Contract::factory()->create();

        $customerData = [
            'name'              => 'Updated Customer Name',
            'managing_director' => 'New Director',
            'phone'             => '123456789',
            'email'             => 'newemail@example.com',
            'street'            => 'New Street',
            'house_number'      => '123A',
            'zip_code'          => '12345',
            'city'              => 'New City',
            'contracts'         => [
                ['id' => $contract->id],
            ],
            'contract_dates'    => [
                $contract->id => [
                    'start_date'  => '2024-01-01',
                    'end_date'    => '2026-01-01',
                    'create_date' => '2024-01-01',
                ],
            ],
        ];

        $response = $this->put(route('customers.update', $customer), $customerData);

        $response->assertRedirect(route('customers.edit', ['customer' => $customer->id]));
        $this->assertDatabaseHas('contract_customer', [
            'customer_id' => $customer->id,
            'contract_id' => $contract->id,
            'start_date'  => '2024-01-01',
            'end_date'    => '2026-01-01',
            'create_date' => '2024-01-01',
        ]);

    }

    // ########## Tests for destroy ##########
    public function test_deletes_customer() {
        $customer = Customer::factory()->create();

        $response = $this->delete(route('customers.destroy', $customer));

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
        $response->assertRedirect(route('customers.index'));

    }
}
