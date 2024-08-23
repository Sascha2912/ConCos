<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'hours',
        'monthly_costs',
        'monthly_costs',
        'start_date',
        'end_date',
    ];

    public static function validationRules() {

        return [
            'name'          => 'required|bail|string|max:255',
            'hours'         => 'nullable|int',
            'monthly_costs' => 'nullable|numeric',
            'flatrate'      => 'nullable|boolean',
            'start_date'    => 'required|bail|date',
            'end_date'      => 'nullable|date',
        ];
    }

    public function customer() {

        return $this->belongsToMany(Customer::class);
    }

    public function services() {

        return $this->belongsToMany(Service::class);
    }

    public function timelogs() {

        return $this->hasMany(Timelog::class);
    }
}
