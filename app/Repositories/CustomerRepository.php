<?php

namespace App\Repositories;

use App\Models\Customer;


class CustomerRepository {

    public function updateOrCreate(array $data, Customer $customer = null) {
        if($customer){
            $customer->update($data);
        }else{
            $customer = Customer::create($data);
        }

        return $customer->fresh();
    }
}