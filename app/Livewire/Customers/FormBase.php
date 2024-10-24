<?php

namespace App\Livewire\Customers;

use App\Models\Contract;
use Livewire\Component;

abstract class FormBase extends Component {

    public $name;
    public $managing_director;
    public $phone;
    public $email;
    public $street;
    public $house_number;
    public $city;
    public $zip_code;
    public $tmpContracts = [];
    public $contractDates = []; // Verwaltet die Vertragsdaten wie Start-/End-Datum
    public $availableContracts;
    public $selectedContractId = null;

    public function mountBase($customer = null) {
        if($customer){
            // Setze die Kundendaten
            $this->name = $customer->name;
            $this->managing_director = $customer->managing_director;
            $this->phone = $customer->phone;
            $this->email = $customer->email;
            $this->street = $customer->street;
            $this->house_number = $customer->house_number;
            $this->city = $customer->city;
            $this->zip_code = $customer->zip_code;

            // Lade die Verträge des Kunden und deren Pivot-Daten
            $this->tmpContracts = $customer->contracts()->withPivot([
                'create_date',
                'start_date',
                'end_date',
            ])->get()->map(function($contract) {
                return [
                    'id'            => $contract->id,
                    'name'          => $contract->name,
                    'monthly_costs' => $contract->monthly_costs,
                    'flatrate'      => $contract->flatrate,
                    'create_date'   => $contract->pivot->create_date,
                    'start_date'    => $contract->pivot->start_date,
                    'end_date'      => $contract->pivot->end_date,

                ];
            })->toArray();
            $this->availableContracts = Contract::whereNotIn('id', array_column($this->tmpContracts, 'id'))->get();
        }else{
            $this->availableContracts = Contract::all();
        }

        // Initialisiere die Vertragsdaten
        foreach($this->tmpContracts as $contract){
            $this->contractDates[$contract['id']] = [
                'create_date' => $contract['create_date'] ?? now()->format('Y-m-d'),
                'start_date'  => $contract['start_date'] ?? null,
                'end_date'    => $contract['end_date'] ?? null,
                // Standardwert für Enddatum
            ];
        }
    }

    public function addContract($contractId) {
        $contract = Contract::find($contractId);
        if($contract && !in_array($contractId, array_column($this->tmpContracts, 'id'))){
            $this->tmpContracts[] = [
                'id'            => $contract->id,
                'name'          => $contract->name,
                'monthly_costs' => $contract->monthly_costs,
                'flatrate'      => $contract->flatrate,
                'create_date'   => now()->format('Y-m-d'),
                'start_date'    => null,
                'end_date'      => null,
            ];

            // Initialisiere die Vertragsdaten für das neue Vertragsverhältnis
            $this->contractDates[$contract->id] = [
                'create_date' => now()->format('Y-m-d'),
                'start_date'  => $contract['start_date'] ?? null,
                'end_date'    => $contract['end_date'] ?? null,
            ];

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

        // Vertrag wieder zur Liste der verfügbaren Verträge hinzufügen
        $contract = Contract::find($contractId);
        if($contract && !$this->availableContracts->contains('id', $contractId)){
            $this->availableContracts->push($contract);
        }
    }

    public function validateCustomerData() {
        $this->validate([
            'name'              => 'required|string',
            'managing_director' => 'required|string',
            'phone'             => 'nullable|string|max:254',
            'email'             => 'required|email|unique:customers,email,'.($this->customer->id ?? 'NULL'),
            'street'            => 'nullable|string|max:254',
            'house_number'      => 'nullable|string|max:254',
            'city'              => 'nullable|string|max:254',
            'zip_code'          => 'nullable|string|max:254',
        ]);
    }

    abstract public function save();
}

