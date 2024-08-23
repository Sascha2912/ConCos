<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timelog extends Model
{
    use HasFactory;

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
