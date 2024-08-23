<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'preferred_language',
        'email',
        'password',
    ];

    public static function validationRules(bool $creating = false) {

        return [
            'firstname'          => 'required|bail|string|max:255',
            'lastname'           => 'required|bail|string|max:255',
            'preferred_language' => 'required|bail|string|max:255',
            'email'              => ($creating ? 'required|bail|' : '').'email|unique:users,email|string|max:255',
            'password'           => 'required|bail|string|min:8|max:255',
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}