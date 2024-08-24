<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timelog extends Model {
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'service_id',
        'contract_id',
        'hours',
        'date',
    ];

    public static function validationRules() {

        return [
            'customer_id' => 'required|integer|exists:customers,id',
            'service_id'  => 'required|integer|exists:services,id',
            'contract_id' => 'required|integer|exists:contracts,id',
            'hours'       => 'required|integer|between:1,24',
            'date'        => 'required|date',
        ];
    }

    public function customer() {

        return $this->belongsTo(Customer::class);
    }

    public function contract() {

        return $this->belongsTo(Contract::class);
    }

    public function service() {

        return $this->belongsTo(Service::class);
    }
}
