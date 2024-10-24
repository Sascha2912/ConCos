<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'costs_per_hour',
    ];

    public static function validationRules() {

        return [
            'name'           => 'required|bail|string|max:255',
            'description'    => 'nullable|bail|string|max:999',
            'costs_per_hour' => 'required|bail|numeric',
        ];
    }

    public function contracts() {

        return $this->belongsToMany(Contract::class, 'contract_service')->withPivot('hours')->withTimestamps();
    }

    public function timelogs() {

        return $this->hasMany(Timelog::class);
    }
}
