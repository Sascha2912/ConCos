<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller {
    public function create() {

        return view('auth.login');
    }

    public function store(Request $request) {
        $attributes = request()->validate([
            'email'    => ['required', 'email', 'max:254'],
            'password' => ['required'],
        ]);

        if( !Auth::attempt($attributes)){
            throw ValidationException::withMessages([
                'password' => __('app.incorrect_password'),
            ]);
        }

        request()->session()->regenerate();

        return redirect('/customers');
    }

    public function destroy() {
        Auth::logout();

        return redirect('/login');
    }
}
