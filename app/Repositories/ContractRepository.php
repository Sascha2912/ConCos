<?php

namespace App\Repositories;

use App\Models\Contract;


class ContractRepository {

    public function updateOrCreate(array $data, Contract $contract = null) {
        if($contract){
            $contract->update($data);
        }else{
            $contract = Contract::create($data);
        }

        return $contract->fresh();
    }
}