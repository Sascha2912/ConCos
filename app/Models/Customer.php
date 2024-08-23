<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'street',
        'house_number',
        'zip_code',
        'city',
        'phone',
    ];

    public static function validationRules(bool $creating = false) {

        return [
            'firstname'    => 'required|bail|string|max:255',
            'lastname'     => 'required|bail|string|max:255',
            'email'        => ($creating ? 'required|bail|' : '').'email|unique:users,email|string|max:255',
            'street'       => 'nullable|string|max:255',
            'house_number' => 'nullable|string|max:255',
            'zip_code'     => 'nullable|string|max:255',
            'city'         => 'nullable|string|max:255',
            'phone'        => 'nullable|string|max:255',
        ];
    }

    public function contracts() {

        return $this->belongsToMany(Contract::class);
    }

    public function timelogs() {

        return $this->hasMany(Timelog::class);
    }
}
