<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class SetUserLocale {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {

        Log::info('SetUserLocale Middleware wurde aufgerufen');

        // Prüfen, ob der Benutzer authentifiziert ist
        if(auth()->check()){
            // Sprache des Benutzers aus 'preferred_language' setzen
            $locale = auth()->user()->preferred_language;

            // Lokale Sprache auf den Wert von 'preferred_language' setzen
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
