<?php

namespace Test\Http\Controllers;

use App\Models\Contract;
use App\Models\Service;
use App\Models\User;
use App\Repositories\ServiceRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ServiceControllerTest extends TestCase {
    use RefreshDatabase;

    protected $serviceRepository;

    protected function setUp(): void {
        parent::setUp();

        $this->serviceRepository = $this->app->make(ServiceRepository::class);
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        // Erstelle den Standardvertrag, falls er nicht existiert
        Contract::firstOrCreate(['name' => '-']);
    }

    // ########## Tests for index ##########
    public function test_displays_services_index() {
        // Arrange: Erstelle einige Services
        Service::factory()->count(5)->create();

        // Act: Rufe die Index-Route auf
        $response = $this->get(route('services.index'));

        // Assert: Überprüfe, ob die Antwort erfolgreich ist und die richtigen Daten an die Ansicht übergeben wurden
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('services.index');
        $response->assertViewHas('services');
    }

    // ########## Tests for create ##########
    public function test_display_service_create_form() {
        // Act: Rufe die Create-Route auf
        $response = $this->get(route('services.create'));

        // Assert: Überprüfe, ob die Antwort erfolgreich ist und das Formular angezeigt wird
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('services.create');
    }

    // ########## Tests for store ##########
    public function test_store_new_service() {
        // Arrange: Erstelle die Service-Daten
        $data = [
            'name'           => 'New Service',
            'description'    => 'This is a new service description',
            'costs_per_hour' => 100,
        ];

        // Act: Rufe die Store-Methode auf und übermittle die Daten
        $response = $this->post(route('services.store'), $data);

        // Assert: Überprüfe, ob der Service in der Datenbank gespeichert wurde
        $this->assertDatabaseHas('services', [
            'name'           => $data['name'],
            'description'    => $data['description'],
            'costs_per_hour' => $data['costs_per_hour'],

        ]);

        $service = Service::where('name', $data['name'])->first();

        // Überprüfe, ob der Standardvertrag '-' zugewiesen wurde
        $defaultContract = Contract::where('name', '-')->first();
        $this->assertNotNull($defaultContract);
        $this->assertDatabaseHas('contract_service', [
            'service_id'  => $service->id,
            'contract_id' => $defaultContract->id,
            'hours'       => null,
        ]);

        // Überprüfe, ob die Weiterleitung zur Edit-Seite korrekt funktioniert
        $response->assertRedirect(route('services.edit', ['service' => $service->id]));
    }

    // ########## Tests for show ##########
    public function test_show_service_details() {
        // Arrange: Erstelle einen Service
        $service = Service::factory()->create();

        // Act: Rufe die Show-Route auf
        $response = $this->get(route('services.show', ['service' => $service->id]));

        // Assert: Überprüfe, ob die Antwort erfolgreich ist und die richtigen Daten an die Ansicht übergeben wurden
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('services.show');
        $response->assertViewHas('service');
    }

    // ########## Tests for edit ##########
    public function test_displays_service_edit_form() {
        // Arrange: Erstelle einen Service
        $service = Service::factory()->create();

        // Act: Rufe die Edit-Route auf
        $response = $this->get(route('services.edit', ['service' => $service->id]));

        // Assert: Überprüfe, ob die Antwort erfolgreich ist und die richtigen Daten an die Ansicht übergeben wurden
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('services.edit');
        $response->assertViewHas('service');
    }

    // ########## Tests for update ##########
    public function test_update_service() {
        // Arrange: Erstelle einen Service
        $service = Service::factory()->create([
            'name'           => 'Old Service',
            'description'    => 'Old service description',
            'costs_per_hour' => 100,
        ]);

        // Die neuen Daten für das Update
        $updateData = [
            'name'           => 'Updated Service',
            'description'    => 'Updated service description',
            'costs_per_hour' => 150,
        ];

        // Act: Rufe die Update-Methode auf und übermittle die neuen Service-Daten
        $response = $this->patch(route('services.update', $service), $updateData);

        // Assert: Überprüfe, ob der Service in der Datenbank aktualisiert wurde
        $this->assertDatabaseHas('services', [
            'name'           => $updateData['name'],
            'description'    => $updateData['description'],
            'costs_per_hour' => $updateData['costs_per_hour'],
        ]);

        // Überprüfe, ob der Standardvertrag '-' weiterhin zugewiesen wurde
        $defaultContract = Contract::where('name', '-')->first();
        $this->assertNotNull($defaultContract);
        $this->assertDatabaseHas('contract_service', [
            'service_id'  => $service->id,
            'contract_id' => $defaultContract->id,
            'hours'       => null,
        ]);

        // Überprüfe, ob die Weiterleitung zur Edit-Seite korrekt funktioniert
        $response->assertRedirect(route('services.edit', ['service' => $service->id]));
    }

    // ########## Tests for destroy ##########
    public function test_deletes_service() {
        // Arrange: Erstelle einen Service
        $service = Service::factory()->create();

        // Act: Rufe die Destroy-Methode auf
        $response = $this->delete(route('services.destroy', ['service' => $service->id]));

        // Assert: Überprüfe, ob der Service aus der Datenbank gelöscht wurde
        $this->assertDatabaseMissing('services', ['id' => $service->id]);

        // Überprüfe, ob die Weiterleitung zur Index-Seite korrekt funktioniert
        $response->assertRedirect(route('services.index'));
    }
}
