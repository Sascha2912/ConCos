<?php

namespace App\Livewire\Customers;

use App\Http\Controllers\CustomerController;
use App\Models\Contract;
use App\Models\Customer;
use Carbon\Carbon;

class Create extends FormBase {
    public function mount() {
        $this->mountBase(); // Ruft die Methode mountBase auf, um die Initialisierung durchzuführen

    }

    public function save() {
        $this->validateCustomer(); // Validierung der Kundendaten

        // Kundendaten vorbereiten
        $data = [
            'name'              => $this->name,
            'managing_director' => $this->managing_director,
            'phone'             => $this->phone,
            'email'             => $this->email,
            'street'            => $this->street,
            'house_number'      => $this->house_number,
            'city'              => $this->city,
            'zip_code'          => $this->zip_code,
            'contracts'         => $this->tmpContracts,
            'contract_dates'    => $this->contractDates,
        ];

        // Speicher den Vertrag über den ContractController
        try{
            $customerController = app(CustomerController::class);
            $customerController->store(new \Illuminate\Http\Request($data));

            session()->flash('message', __('app.customer_created_successfully'));
        }catch(\Exception $e){
            // Fehlerbehandlung
            session()->flash('error', __('app.create_customer_failed'));
        }
    }

    public function render() {
        return view('livewire.customers.create')->layout('layouts.app');
    }
}
