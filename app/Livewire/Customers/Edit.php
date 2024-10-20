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
    public $tmpContracts = [];
    public $availableContracts;
    public $selectedContractId = null; // Zum Speichern der aktuellen Auswahl im Dropdown

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

        $this->tmpContracts = $customer->contracts->toArray();

        // Nur die Verträge anzeigen, die dem Kunden noch nicht zugewiesen sind
        $this->availableContracts = Contract::whereNotIn('id', array_column($this->tmpContracts, 'id'))->get();
    }

    public function addContract($contractId) {
        $contract = Contract::find($contractId);
        if($contract && !in_array($contractId, array_column($this->tmpContracts, 'id'))){
            // Füge das gesamte Vertragsmodell hinzu, nicht nur die ID
            $this->tmpContracts[] = $contract->toArray();

            // Entferne den hinzugefügten Vertrag aus der Liste der verfügbaren Verträge
            $this->availableContracts = $this->availableContracts->filter(function($contract) use ($contractId) {
                return $contract->id != $contractId;
            });

            // Setze die Dropdown-Auswahl zurück
            $this->reset('selectedContractId');

        }
    }

    public function removeContract($contractId) {
        // Entferne das Vertragmodell aus der temporären Liste
        $this->tmpContracts = array_filter($this->tmpContracts, function($contract) use ($contractId) {
            return $contract['id'] != $contractId; // Entferne den Vertrag mit der angegebenen ID
        });


        // Füge den Vertrag zurück zu den verfügbaren Verträgen hinzu
        $contract = Contract::find($contractId);
        if($contract && !$this->availableContracts->contains('id', $contractId)){
            $this->availableContracts->push($contract);
        }
    }

    public function save() {
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

        // Extrahiere nur die IDs der Verträge aus der temporären Liste und synchronisiere
        $contractIds = array_column($this->tmpContracts, 'id'); // Nur die IDs extrahieren
        $this->customer->contracts()->sync($contractIds);

        session()->flash('message', 'Customer updated successfully.');

        return redirect()->route('customers.edit', $this->customer);
    }

    public function render() {
        return view('livewire.customers.edit')->layout('layouts.app');
    }
}
