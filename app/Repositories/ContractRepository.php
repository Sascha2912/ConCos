<?php

namespace App\Repositories;

use App\Models\Contract;
use Illuminate\Http\Request;


class ContractRepository {

    public function updateOrCreate(array $data, Request $request, Contract $contract = null) {
        if($contract){
            $contract->update($data);
        }else{
            $contract = Contract::create($data);
        }

        $servicesWithHours = collect($request->input('services'))->mapWithKeys(function($serviceData, $serviceId) use (
            $contract
        ) {
            return [
                $serviceId => ['hours' => $contract->flatrate ? 0 : $serviceData['hours']],
            ];
        })->toArray();

        $contract->services()->sync($servicesWithHours);

        return $contract->fresh();
    }
}