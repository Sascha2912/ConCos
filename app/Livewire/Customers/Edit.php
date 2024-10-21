<?php

namespace App\Livewire\Customers;

use App\Models\Customer;

class Edit extends FormBase {
    public $customer;

    public function mount(Customer $customer) {
        $this->customer = $customer;
        $this->mountBase($customer);
    }

    public function save() {
        $this->validateCustomerData();

        $this->customer->update([
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
        $this->customer->contracts()->sync($contractIds);

        session()->flash('message', 'Customer updated successfully.');

        return redirect()->route('customers.edit', $this->customer);
    }

    public function render() {
        return view('livewire.customers.edit')->layout('layouts.app');
    }
}
