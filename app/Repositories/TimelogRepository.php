<?php

namespace App\Repositories;

use App\Models\Timelog;


class TimelogRepository {

    public function updateOrCreate(array $data, Timelog $timelog = null) {
        if($timelog){
            $timelog->update($data);
        }else{
            $timelog = Timelog::create($data);
        }

        return $timelog->fresh();
    }
}