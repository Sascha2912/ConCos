<?php

namespace App\Repositories;

use App\Models\Service;


class ServiceRepository {

    public function updateOrCreate(array $data, Service $service = null) {
        if($service){
            $service->update($data);
        }else{
            $service = Service::create($data);
        }

        return $service->fresh();
    }
}