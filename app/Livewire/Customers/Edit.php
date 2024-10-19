<?php

namespace App\Livewire\Customers;

use App\Models\Contract;
use App\Models\Customer;
use Livewire\Component;

class Edit extends Component {

    public $customer;
    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $street;
    public $house_number;
    public $city;
    public $zip_code;

    public function mount(Customer $customer) {
        $this->customer = $customer;
        $this->firstname = $customer->firstname;
        $this->lastname = $customer->lastname;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
        $this->street = $customer->street;
        $this->house_number = $customer->house_number;
        $this->city = $customer->city;
        $this->zip_code = $customer->zip_code;

    }

    public function save() {

        // Validierung der Kundenfelder
        $this->validate([
            'firstname'    => 'required|string',
            'lastname'     => 'required|string',
            'email'        => 'required|email',
            'phone'        => 'nullable|string|max:254',
            'street'       => 'nullable|string|max:254',
            'house_number' => 'nullable|string|max:254',
            'city'         => 'nullable|string|max:254',
            'zip_code'     => 'nullable|string|max:254',
        ]);

        // Update der Kundeninformationen
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

        session()->flash('message', 'Customer updated successfully.');

        return redirect()->route('customers.edit', $this->customer);
    }

    public function render() {

        return view('livewire.customers.edit')->layout('layouts.app');
    }
}
