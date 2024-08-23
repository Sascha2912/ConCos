<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function contracts() {

        return $this->belongsToMany(Contract::class);
    }

    public function timelogs() {

        return $this->hasMany(Timelog::class);
    }
}
