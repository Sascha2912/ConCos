<?php

namespace App\Livewire\Timelogs;

use App\Models\Customer;
use App\Models\Timelog;
use Livewire\Component;

class Create extends FormBase {

    public $customer_id;
    public $customer;

    public function mount($customer) {
        // Setze die customer_id aus dem Parameter und lade die Basisdaten
        $this->customer_id = $customer;
        $this->customer = Customer::find($this->customer_id);

        $this->mountBase();

        // Lade die Contracts des Kunden
        $this->loadContracts();
    }

    public function save() {
        $this->validateTimelog();

        $timelog = Timelog::create([
            'customer_id' => $this->customer_id,
            'contract_id' => $this->selectedContractId,
            'service_id'  => $this->selectedServiceId,
            'hours'       => $this->hours,
            'date'        => $this->date,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Timelog created successfully.');

        return redirect(route('timelogs.index', $this->customer_id));
    }

    public function render() {
        return view('livewire.timelogs.create')->layout('layouts.app');
    }
}
