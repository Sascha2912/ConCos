<?php

namespace Test\Http\Middleware;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class SetUserLocaleTest extends TestCase {
    use RefreshDatabase;

    public function test_locale_is_set_for_authenticated_user() {
        // Benutzer mit einer bevorzugten Sprache erstellen
        $user = User::factory()->create(['preferred_language' => 'de']);

        // Log überwachen, um sicherzustellen, dass die Middleware ausgeführt wird
        Log::spy();

        // Route mit dem Benutzer aufrufen
        $this->actingAs($user)->get('/customers'); // Beispielroute, die die Middleware nutzt

        // Überprüfen, dass die Lokalisierung auf 'de' gesetzt ist
        $this->assertEquals('de', App::getLocale());

        // Verifizieren, dass der Log-Eintrag erstellt wurde
        Log::shouldHaveReceived('info')->once()->with('SetUserLocale Middleware wurde aufgerufen');
    }
}
