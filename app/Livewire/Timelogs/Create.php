<?php

namespace App\Livewire\Timelogs;

use App\Http\Controllers\TimelogController;
use App\Models\Customer;
use App\Models\Timelog;
use Livewire\Component;

class Create extends FormBase {

    public $customer_id;
    public $customer;

    public function mount($customer) {
        // Setze die customer_id aus dem Parameter und lade die Basisdaten
        $this->customer_id = $customer->id;
        $this->customer = $customer;

        $this->mountBase();

        // Lade die Contracts des Kunden
        $this->loadContracts();
    }

    public function save() {
        $this->validateTimelog();

        $data = [
            'customer_id' => $this->customer_id,
            'contract_id' => $this->selectedContractId,
            'service_id'  => $this->selectedServiceId,
            'hours'       => $this->hours,
            'date'        => $this->date,
            'description' => $this->description,
        ];

        // Rufe den TimelogController auf, um die Daten zu speichern
        try{
            $timelogController = app(TimelogController::class);
            $timelogController->store(new \Illuminate\Http\Request($data));

            session()->flash('message', __('app.timelog_created_successfully'));
        }catch(\Exception $e){
            // Fehlerbehandlung
            session()->flash('error', __('app.create_timelog_failed'));
        }
    }

    public function render() {
        return view('livewire.timelogs.create')->layout('layouts.app');
    }
}
