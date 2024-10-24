<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Carbon\Carbon;

class Create extends FormBase {
    public function mount() {
        $this->mountBase(); // Ruft die Methode mountBase auf, um die Initialisierung durchzuführen

    }

    public function save() {
        $this->validateCustomerData(); // Validierung der Kundendaten

        $customer = Customer::create([
            'name'              => $this->name,
            'managing_director' => $this->managing_director,
            'phone'             => $this->phone,
            'email'             => $this->email,
            'street'            => $this->street,
            'house_number'      => $this->house_number,
            'city'              => $this->city,
            'zip_code'          => $this->zip_code,
        ]);

        // Bereite die Vertragsdaten für die Pivot-Tabelle vor
        $contractsWithDates = [];
        foreach($this->tmpContracts as $contract){
            $start_date = $this->contractDates[$contract['id']]['start_date'];
            if( !$start_date){
                session()->flash('error', 'Start date is required for all contracts.');

                return;
            }

            $end_date = $this->contractDates[$contract['id']]['end_date'] ?? Carbon::parse($start_date)->addYears(2)->format('Y-m-d'); // Standardwert für Enddatum

            $contractsWithDates[$contract['id']] = [
                'create_date' => $this->contractDates[$contract['id']]['create_date'] ?? now()->format('Y-m-d'),
                'start_date'  => $start_date,
                'end_date'    => $end_date,
            ];
        }

        // Synchronisiere die Vertragsdaten mit der Pivot-Tabelle
        $customer->contracts()->sync($contractsWithDates);

        session()->flash('message', 'Customer created successfully.');

        return redirect()->route('customers.edit', $customer);
    }

    public function render() {
        return view('livewire.customers.create')->layout('layouts.app');
    }
}
