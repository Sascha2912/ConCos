<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    const ROLE_VIEWER = 'viewer';
    const ROLe_EDITOR = 'editor';
    const ROLE_ADMIN = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'role',
        'preferred_language',
        'email',
        'password',
    ];

    public static function validationRules(bool $creating = false) {

        return [
            'firstname'          => 'required|bail|string|max:255',
            'lastname'           => 'required|bail|string|max:255',
            'role'               => 'required|bail|string|in:viewer,editor,admin',
            'preferred_language' => 'nullable|string|max:255',
            'email'              => ($creating ? 'required|bail|' : '').'email|unique:users,email|string|max:255',
            'password'           => ($creating ? 'required|bail|' : 'nullable|').'string|min:8|confirmed',
            'current_password'   => 'nullable|string|min:8', // Aktuelles Passwort ist erforderlich
            'new_password'       => 'nullable|string|min:8|confirmed', // Neues Passwort

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

    public function isViewer() {

        return $this->role === self::ROLE_VIEWER;
    }

    public function isEditor() {

        return $this->role === self::ROLe_EDITOR;
    }

    public function isAdmin() {

        return $this->role === self::ROLE_ADMIN;
    }
}