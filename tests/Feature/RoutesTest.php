<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class RoutesTest extends TestCase {
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'admin']);
    }

    public function test_redirect_from_home_to_customers() {

        $this->actingAs($this->user)->get('/')->assertRedirect('/customers');
    }

    public function test_guest_cannot_access_protected_routes() {
        $protectedRoutes = [
            '/users/1/profile/edit',
            '/customers',
            '/contracts',
            '/services',
        ];

        foreach($protectedRoutes as $route){
            $this->get($route)->assertRedirect('/login');
        }
    }

    public function test_authenticated_user_can_access_protected_routes() {
        $user = User::factory()->create(['role' => 'admin']);
        $protectedRoutes = [
            '/users',
            '/customers',
            '/contracts',
            '/services',
        ];

        foreach($protectedRoutes as $route){
            $this->actingAs($user)->get($route)->assertStatus(Response::HTTP_OK);
        }
    }

    public function test_crud_routes_for_each_resource() {
        $user = User::factory()->create(['role' => 'admin']);
        $resources = [
            'users'     => ['name' => 'Test User', 'email' => 'testuser@example.com', 'password' => 'password'],
            'customers' => ['name' => 'Test Customer'],
            'contracts' => ['title' => 'Test Contract'],
            'services'  => ['name' => 'Test Service'],
        ];

        foreach($resources as $resource => $data){
            // Index route
            $this->actingAs($user)->get("/$resource")->assertStatus(Response::HTTP_OK);

            // Create route
            $this->actingAs($user)->get("/$resource/create")->assertStatus(Response::HTTP_OK);

            // Store route
            $this->actingAs($user)->post("/$resource", $data)->assertStatus(Response::HTTP_FOUND);

            // Show, Edit, Update, Delete routes (creating a new model instance to test)
            $model = app("App\\Models\\".ucfirst(rtrim($resource, 's')))::factory()->create();

            $this->actingAs($user)->get("/$resource/{$model->id}")->assertStatus(Response::HTTP_OK);           // Show
            $this->actingAs($user)->get("/$resource/{$model->id}/edit")->assertStatus(Response::HTTP_OK);      // Edit
            $this->actingAs($user)->put("/$resource/{$model->id}",
                $data)->assertStatus(Response::HTTP_FOUND);                                                          // Update
            $this->actingAs($user)->delete("/$resource/{$model->id}")->assertStatus(Response::HTTP_FOUND);           // Destroy
        }
    }

    public function test_login_rotes_are_accessible_for_guest_only() {
        // Gäste haben Zugriff auf die Login-Seiten
        $this->get('/login')->assertStatus(Response::HTTP_OK);
        $this->post('/login')->assertStatus(Response::HTTP_FOUND);

        // Authentifizierte Benutzer werden umgeleitet
        $this->actingAs($this->user)->get('/login')->assertRedirect('/');

    }

    public function test_user_locale_is_set_for_authenticated_user() {
        $user = User::factory()->create(['preferred_language' => 'de']);

        $this->actingAs($user)->get('/customers');

        // Überprüfen, ob die Lokalisierung auf die bevorzugte Sprache des Benutzers gesetzt wurde
        $this->assertEquals('de', app()->getLocale());
    }
}
