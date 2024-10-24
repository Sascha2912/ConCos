<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'monthly_costs',
        'flatrate',
    ];

    // Standardwert auf 0 setzen, falls kein Wert angegeben wurde
    public function setMonthlyCostAttribute($value) {
        $this->attributes['monthly_cost'] = $value ?? 0;
    }

    public static function validationRules() {

        return [
            'name'          => 'required|bail|string|max:255',
            'monthly_costs' => 'nullable|numeric',
            'flatrate'      => 'nullable|boolean',
        ];
    }

    public function customers() {

        return $this->belongsToMany(Customer::class)->withPivot('create_date', 'start_date',
            'end_date')->withTimestamps();
    }

    public function services() {

        return $this->belongsToMany(Service::class, 'contract_service')->withPivot('hours')->withTimestamps();
    }

    public function timelogs() {

        return $this->hasMany(Timelog::class);
    }
}
