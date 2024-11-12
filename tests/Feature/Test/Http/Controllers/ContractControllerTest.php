<?php

namespace Test\Http\Controllers;

use App\Models\Contract;
use App\Models\Service;
use App\Models\User;
use App\Repositories\ContractRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContractControllerTest extends TestCase {
    use RefreshDatabase, WithFaker;

    protected ContractRepository $contractRepository;

    protected function setUp(): void {
        parent::setUp();

        $this->contractRepository = $this->app->make(ContractRepository::class);
        $this->actingAs(User::factory()->create(['role' => 'admin']));
    }

    // ########## Tests for index ##########
    public function test_displays_contracts_index() {
        Contract::factory()->count(15)->create();

        $response = $this->get(route('contracts.index'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('contracts.index');
        $response->assertViewHas('contracts');
    }

    // ########## Tests for create ##########
    public function test_display_contract_create_form_with_services() {
        Service::factory()->count(5)->create();

        $response = $this->get(route('contracts.create'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('contracts.create');
        $response->assertViewHas('services');
    }

    // ########## Tests for store ##########
    public function test_store_new_contract_with_service_data() {
        // Arrange: Erstelle die Service-Daten und die Vertragsdaten
        $service1 = Service::factory()->create();
        $service2 = Service::factory()->create();

        $contractData = [
            'name'          => $this->faker->company,
            'monthly_costs' => $this->faker->randomFloat(2, 100, 500),
            'flatrate'      => false,
            'services'      => [
                $service1->id => ['hours' => 10],
                $service2->id => ['hours' => 20],
            ],
        ];

        // Act: Rufe die `store`-Methode auf und übermittle die Vertragsdaten
        $response = $this->post(route('contracts.store'), $contractData);

        // Assert: Überprüfe, ob der Vertrag korrekt in der Datenbank gespeichert wurde
        $this->assertDatabaseHas('contracts', [
            'name'          => $contractData['name'],
            'monthly_costs' => $contractData['monthly_costs'],
            'flatrate'      => $contractData['flatrate'],
        ]);

        $contract = Contract::where('name', $contractData['name'])->first();

        // Überprüfe, ob die Services mit den korrekten Stunden in der Pivot-Tabelle gespeichert sind
        $this->assertDatabaseHas('contract_service', [
            'contract_id' => $contract->id,
            'service_id'  => $service1->id,
            'hours'       => 10,
        ]);

        $this->assertDatabaseHas('contract_service', [
            'contract_id' => $contract->id,
            'service_id'  => $service2->id,
            'hours'       => 20,
        ]);

        // Überprüfe, ob die Weiterleitung zur Edit-Seite korrekt funktioniert
        $response->assertRedirect(route('contracts.edit', ['contract' => $contract->id]));
    }

    public function test_sets_service_hours_to_zero_when_at_create_flatrate_is_true() {
        // Arrange: Erstelle die Service-Daten und die Vertragsdaten mit `flatrate` auf `true`
        $service1 = Service::factory()->create();
        $service2 = Service::factory()->create();

        $contractData = [
            'name'          => $this->faker->company,
            'monthly_costs' => $this->faker->randomFloat(2, 100, 500),
            'flatrate'      => true,
            'services'      => [
                $service1->id => ['hours' => 10], // Stundenwerte sollten ignoriert und auf 0 gesetzt werden
                $service2->id => ['hours' => 20],
            ],
        ];

        // Act: Rufe die `store`-Methode auf und übermittle die Vertragsdaten
        $response = $this->post(route('contracts.store'), $contractData);

        // Assert: Überprüfe, ob der Vertrag korrekt in der Datenbank gespeichert wurde
        $this->assertDatabaseHas('contracts', [
            'name'          => $contractData['name'],
            'monthly_costs' => $contractData['monthly_costs'],
            'flatrate'      => $contractData['flatrate'],
        ]);

        $contract = Contract::where('name', $contractData['name'])->first();

        // Überprüfe, ob die Services in der Pivot-Tabelle mit `hours` auf `0` gesetzt sind
        $this->assertDatabaseHas('contract_service', [
            'contract_id' => $contract->id,
            'service_id'  => $service1->id,
            'hours'       => 0,
        ]);

        $this->assertDatabaseHas('contract_service', [
            'contract_id' => $contract->id,
            'service_id'  => $service2->id,
            'hours'       => 0,
        ]);

        // Überprüfe, ob die Weiterleitung zur Edit-Seite korrekt funktioniert
        $response->assertRedirect(route('contracts.edit', ['contract' => $contract->id]));
    }

    // ########## Tests for show ##########
    public function test_show_contract_details_with_services() {
        $contract = Contract::factory()->create();
        $service = Service::factory()->create();
        $contract->services()->attach($service->id, ['hours' => 5]);

        $response = $this->get(route('contracts.show', $contract));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('contracts.show');
        $response->assertViewHas('contract');
        $response->assertViewHas('services');
    }

    // ########## Tests for edit ##########
    public function test_displays_contract_edit_form_with_contract_and_services() {
        $contract = Contract::factory()->create();
        $services = Service::factory()->count(3)->create();
        $contract->services()->attach($services, [
            'hours' => 5,
        ]);

        $response = $this->get(route('contracts.edit', $contract));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('contracts.edit');
        $response->assertViewHas('contract');
        $response->assertViewHas('services');
    }

    // ########## Tests for update ##########
    public function test_update_contract_with_service_data() {
        // Arrange: Erstelle den Vertrag und die Service-Daten
        $contract = Contract::factory()->create([
            'name'          => 'Old company name',
            'monthly_costs' => 1000,
            'flatrate'      => false,
        ]);

        $service1 = Service::factory()->create();
        $service2 = Service::factory()->create();

        $contract->services()->attach([
            $service1->id => ['hours' => 10],
            $service2->id => ['hours' => 20],
        ]);

        // Act: Rufe die `update`-Methode auf und übermittle die Vertragsdaten
        $updateData = [
            'name'          => 'New Company Name',
            'monthly_costs' => 1200,
            'flatrate'      => false,
            'services'      => [
                $service1->id => ['hours' => 8],
                $service2->id => ['hours' => 15],
            ],
        ];

        $response = $this->patch(route('contracts.update', $contract), $updateData);

        // Assert: Überprüfe, ob der Vertrag korrekt in der Datenbank gespeichert wurde
        $this->assertDatabaseHas('contracts', [
            'id'            => $contract->id,
            'name'          => 'New Company Name',
            'monthly_costs' => 1200,
        ]);

        // Überprüfe, ob die Services mit den korrekten Stunden in der Pivot-Tabelle gespeichert sind
        $this->assertDatabaseHas('contract_service', [
            'contract_id' => $contract->id,
            'service_id'  => $service1->id,
            'hours'       => 8,
        ]);

        $this->assertDatabaseHas('contract_service', [
            'contract_id' => $contract->id,
            'service_id'  => $service2->id,
            'hours'       => 15,
        ]);

        // Überprüfe, ob die Weiterleitung zur Edit-Seite korrekt funktioniert
        $response->assertRedirect(route('contracts.edit', ['contract' => $contract->id]));

    }

    public function test_sets_service_hours_to_zero_when_flatrate_updated_to_true() {
        // Arrange: Erstelle die Service-Daten und die Vertragsdaten mit `flatrate` auf `false`
        $contract = Contract::factory()->create([
            'name'          => 'Old Company Name',
            'monthly_costs' => 1000,
            'flatrate'      => false,
        ]);

        $service1 = Service::factory()->create();
        $service2 = Service::factory()->create();

        $contract->services()->attach([
            $service1->id => ['hours' => 10],
            $service2->id => ['hours' => 20],
        ]);

        // Act: Rufe die `update`-Methode auf und übermittle die Vertragsdaten mit `flatrate` auf `true`
        $updateData = [
            'name'          => 'Updated Contract Name with Flatrate',
            'monthly_costs' => 1300,
            'flatrate'      => true,  // Setting flatrate to true
            'services'      => [
                $service1->id => ['hours' => 8],  // These hours should be ignored
                $service2->id => ['hours' => 15], // These hours should be ignored
            ],
        ];

        $response = $this->patch(route('contracts.update', $contract), $updateData);


        // Assert: Überprüfe, ob der Vertrag korrekt in der Datenbank gespeichert wurde
        $this->assertDatabaseHas('contracts', [
            'id'            => $contract->id,
            'name'          => $updateData['name'],
            'monthly_costs' => $updateData['monthly_costs'],
            'flatrate'      => $updateData['flatrate'],
        ]);

        // Überprüfe, ob die Services in der Pivot-Tabelle mit `hours` auf `0` gesetzt sind
        $this->assertDatabaseHas('contract_service', [
            'contract_id' => $contract->id,
            'service_id'  => $service1->id,
            'hours'       => 0,
        ]);

        $this->assertDatabaseHas('contract_service', [
            'contract_id' => $contract->id,
            'service_id'  => $service2->id,
            'hours'       => 0,
        ]);

        // Überprüfe, ob die Weiterleitung zur Edit-Seite korrekt funktioniert
        $response->assertRedirect(route('contracts.edit', $contract));
    }

    // ########## Tests for destroy ##########
    public function test_deletes_contract() {
        $contract = Contract::factory()->create();

        $response = $this->delete(route('contracts.destroy', $contract));

        $this->assertDatabaseMissing('contracts', ['id' => $contract->id]);
        $response->assertRedirect(route('contracts.index'));

    }
}
