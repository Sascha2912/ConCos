<?php

namespace App\Repositories;

use App\Models\Contract;
use App\Models\Service;


class ServiceRepository {

    public function updateOrCreate(array $data, Service $service = null) {
        if($service){
            $service->update($data);
        }else{
            $service = Service::create($data);
        }

        // Stelle sicher, dass der Service immer dem Standardvertrag zugeordnet bleibt
        $defaultContract = Contract::where('name', '-')->first();
        if($defaultContract && !$service->contracts()->where('contract_id', $defaultContract->id)->exists()){
            $service->contracts()->sync($defaultContract->id, ['hours' => null]);
        }

        return $service->fresh();
    }
}