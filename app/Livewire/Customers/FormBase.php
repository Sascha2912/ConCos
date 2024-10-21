<?php

namespace App\Livewire\Customers;

use App\Models\Contract;
use Livewire\Component;

abstract class FormBase extends Component {

    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $street;
    public $house_number;
    public $city;
    public $zip_code;
    public $tmpContracts = [];
    public $availableContracts;
    public $selectedContractId = null;

    public function mountBase($customer = null) {
        if($customer){
            $this->firstname = $customer->firstname;
            $this->lastname = $customer->lastname;
            $this->email = $customer->email;
            $this->phone = $customer->phone;
            $this->street = $customer->street;
            $this->house_number = $customer->house_number;
            $this->city = $customer->city;
            $this->zip_code = $customer->zip_code;

            $this->tmpContracts = $customer->contracts->toArray();
            $this->availableContracts = Contract::whereNotIn('id', array_column($this->tmpContracts, 'id'))->get();
        }else{
            $this->availableContracts = Contract::all();
        }
    }

    public function addContract($contractId) {
        $contract = Contract::find($contractId);
        if($contract && !in_array($contractId, array_column($this->tmpContracts, 'id'))){
            $this->tmpContracts[] = $contract->toArray();
            $this->availableContracts = $this->availableContracts->filter(function($contract) use ($contractId) {
                return $contract->id != $contractId;
            });
            $this->reset('selectedContractId');
        }
    }

    public function removeContract($contractId) {
        $this->tmpContracts = array_filter($this->tmpContracts, function($contract) use ($contractId) {
            return $contract['id'] != $contractId;
        });

        $contract = Contract::find($contractId);
        if($contract && !$this->availableContracts->contains('id', $contractId)){
            $this->availableContracts->push($contract);
        }
    }

    public function validateCustomerData() {
        $this->validate([
            'firstname'    => 'required|string',
            'lastname'     => 'required|string',
            'email'        => 'required|email|unique:customers,email,'.($this->customer->id ?? 'NULL'),
            'phone'        => 'nullable|string|max:254',
            'street'       => 'nullable|string|max:254',
            'house_number' => 'nullable|string|max:254',
            'city'         => 'nullable|string|max:254',
            'zip_code'     => 'nullable|string|max:254',
        ]);
    }
}