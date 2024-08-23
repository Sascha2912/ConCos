<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    public function customer() {

        return $this->belongsTo(Customer::class);
    }

    public function services() {

        return $this->belongsToMany(Service::class);
    }

    public function timelogs() {

        return $this->hasMany(Timelog::class);
    }
}
