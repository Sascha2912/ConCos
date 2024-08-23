<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cost_per_hour',
    ];

    public static function validationRules() {

        return [
            'name'          => 'required|bail|string|max:255',
            'description'   => 'nullable|bail|string',
            'cost_per_hour' => 'required|bail|numeric',
        ];
    }

    public function contracts() {

        return $this->belongsToMany(Contract::class);
    }

    public function timelogs() {

        return $this->hasMany(Timelog::class);
    }
}
