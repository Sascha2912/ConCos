<?php

namespace App\Livewire\Customers;

use App\Models\Customer;

class Create extends FormBase {
    public function mount() {
        $this->mountBase();
    }

    public function save() {
        $this->validateCustomerData();

        $customer = Customer::create([
            'firstname'    => $this->firstname,
            'lastname'     => $this->lastname,
            'email'        => $this->email,
            'phone'        => $this->phone,
            'street'       => $this->street,
            'house_number' => $this->house_number,
            'city'         => $this->city,
            'zip_code'     => $this->zip_code,
        ]);

        $contractIds = array_column($this->tmpContracts, 'id');
        $customer->contracts()->sync($contractIds);

        session()->flash('message', 'Customer created successfully.');

        return redirect()->route('customers.edit', $customer);
    }

    public function render() {
        return view('livewire.customers.create')->layout('layouts.app');
    }
}
