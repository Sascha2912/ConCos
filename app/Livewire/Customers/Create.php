<?php

namespace App\Livewire\Customers;

use App\Http\Controllers\CustomerController;
use App\Models\Customer;
use Carbon\Carbon;

class Create extends FormBase {
    public function mount() {
        $this->mountBase(); // Ruft die Methode mountBase auf, um die Initialisierung durchzuführen

    }

    public function save() {
        $this->validateCustomer(); // Validierung der Kundendaten

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

        // Bereite die Vertragsdaten für die Pivot-Tabelle vor
        $contractsWithDates = [];
        foreach($this->tmpContracts as $contract){
            $start_date = $this->contractDates[$contract['id']]['start_date'];
            if( !$start_date){
                session()->flash('error', __('app.start_date_is_required_for_all_contracts'));

                return;
            }

            $end_date = $this->contractDates[$contract['id']]['end_date'] ?? Carbon::parse($start_date)->addYears(2)->format('Y-m-d'); // Standardwert für Enddatum

            $contractsWithDates[$contract['id']] = [
                'create_date' => $this->contractDates[$contract['id']]['create_date'] ?? now()->format('Y-m-d'),
                'start_date'  => $start_date,
                'end_date'    => $end_date,
            ];
        }

        // Speicher den Vertrag über den ContractController
        try{
            $customerController = app(CustomerController::class);
            $customerController->store(new \Illuminate\Http\Request($data, ['contracts' => $contractsWithDates]));

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
