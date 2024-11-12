<?php

namespace Test\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase {
    use RefreshDatabase;

    protected $userRepository;

    protected function setUp(): void {
        parent::setUp();

        $this->userRepository = $this->app->make(UserRepository::class);
        $this->actingAs(User::factory()->create(['role' => 'admin']));
    }

    // ########## Tests for index ##########
    public function test_displays_users_index() {
        // Arrange: Erstelle mehrere User
        User::factory(5)->create();

        // Act: Rufe die index-Seite auf
        $response = $this->get(route('users.index'));

        // Assert: Überprüfe, ob die Benutzer angezeigt werden
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.index');
        $response->assertViewHas('users');
    }

    // ########## Tests for create ##########
    public function test_display_user_create_form() {
        // Act: Rufe das Erstellungsformular auf
        $response = $this->get(route('users.create'));

        // Assert: Überprüfe, ob das Formular korrekt geladen wurde
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.create');
        $response->assertViewHas('roles');
    }

    // ########## Tests for store ##########
    public function test_store_new_user() {
        // Arrange: Erstelle User-Daten
        $data = [
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'john.doe@example.com',
            'password'  => 'password123',
            'role'      => 'viewer',
        ];

        // Act: Rufe die `store`-Methode auf, um einen neuen Benutzer zu erstellen
        $response = $this->post(route('users.store'), $data);

        // Assert: Überprüfe, ob der Benutzer korrekt in der Datenbank gespeichert wurde
        $this->assertDatabaseHas('users', [
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'john.doe@example.com',
        ]);

        // Überprüfe, ob die Weiterleitung zur Index-Seite korrekt funktioniert
        $response->assertRedirect(route('users.index'));
    }

    // ########## Tests for show ##########
    public function test_show_user_details() {
        // Arrange: Erstelle einen Benutzer
        $user = User::factory()->create();

        // Act: Rufe die `show`-Methode für den Benutzer auf
        $response = $this->get(route('users.show', $user));

        // Assert: Überprüfe, ob die Benutzerdetails angezeigt werden
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.edit');
        $response->assertViewHas('user');
    }

    // ########## Tests for edit ##########
    public function test_displays_user_edit_form() {
        // Arrange: Erstelle einen Benutzer
        $user = User::factory()->create();

        // Act: Rufe das Bearbeitungsformular auf
        $response = $this->get(route('users.edit', $user));

        // Assert: Überprüfe, ob das Bearbeitungsformular korrekt geladen wurde
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.edit');
        $response->assertViewHas('user');
    }

    // ########## Tests for update ##########
    public function test_update_user() {
        // Arrange: Erstelle einen Benutzer
        $user = User::factory()->create([
            'firstname' => 'Old Jane',
            'lastname'  => 'Old Doe',
            'email'     => 'jane.doe@example.com',
            'role'      => 'editor',
        ]);
        $data = [
            'firstname' => 'New Jane',
            'lastname'  => 'New Doe',
            'email'     => 'jane.doe@example.com',
            'role'      => 'editor',
        ];

        // Act: Rufe die `update`-Methode auf, um die Benutzerdaten zu aktualisieren
        $response = $this->patch(route('users.update', $user), $data);

        // Assert: Überprüfe, ob die Benutzerdaten in der Datenbank aktualisiert wurden
        $this->assertDatabaseHas('users', [
            'id'        => $user->id,
            'firstname' => 'New Jane',
            'lastname'  => 'New Doe',
            'email'     => 'jane.doe@example.com',
            'role'      => 'editor',
        ]);

        // Überprüfe, ob die Weiterleitung zur Edit-Seite korrekt funktioniert
        $response->assertRedirect(route('users.edit', $user));
    }

    // ########## Tests for destroy ##########
    public function test_deletes_user() {
        // Arrange: Erstelle einen Benutzer
        $user = User::factory()->create();

        // Act: Rufe die `destroy`-Methode auf, um den Benutzer zu löschen
        $response = $this->delete(route('users.destroy', $user));

        // Assert: Überprüfe, ob der Benutzer aus der Datenbank entfernt wurde
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);

        // Überprüfe, ob die Weiterleitung zur Index-Seite korrekt funktioniert
        $response->assertRedirect(route('users.index'));
    }
}
