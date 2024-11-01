<?php

namespace App\Livewire\Customers;

use App\Http\Controllers\CustomerController;
use App\Models\Customer;
use Carbon\Carbon;

class Edit extends FormBase {
    public $customer;

    public function mount(Customer $customer) {
        $this->customer = $customer;
        $this->mountBase($customer); // Lädt die Kundendaten und Verträge
    }

    public function save() {
        $this->validateCustomer();

        // Aktualisiere die Kundendaten
        $data = [
            'name'              => $this->name,
            'managing_director' => $this->managing_director,
            'phone'             => $this->phone,
            'email'             => $this->email,
            'street'            => $this->street,
            'house_number'      => $this->house_number,
            'city'              => $this->city,
            'zip_code'          => $this->zip_code,
        ];

        // Aktualisiere die Daten
        $contractsData = [
            'contracts'      => $this->tmpContracts,
            'contract_dates' => $this->contractDates,
        ];

        // Speicher den Vertrag über den ContractController
        try{
            $customerController = app(CustomerController::class);
            $customerController->update(new \Illuminate\Http\Request($data), $this->customer, $contractsData);

            session()->flash('message', __('app.customer_updated_successfully'));
        }catch(\Exception $e){
            // Fehlerbehandlung
            session()->flash('error', __('app.update_customer_failed'));
        }
    }

    public function deleteCustomer() {
        $customerController = app(CustomerController::class);
        $customerController->destroy($this->customer);
    }

    public function render() {
        return view('livewire.customers.edit')->layout('layouts.app');
    }
}
