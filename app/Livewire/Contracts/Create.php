<?php

namespace App\Livewire\Contracts;

use App\Http\Controllers\ContractController;
use App\Models\Contract;
use App\Models\Service;
use Illuminate\Support\Facades\Http;

class Create extends FormBase {

    public function mount($services) {
        $this->availableServices = $services; // Initialisiere die verfügbaren Services
        $this->mountBase();                   // Lädt die verfügbaren Services ohne einen bestehenden Vertrag.
    }

    public function save() {
        $this->validateContract();

        $flatrateValue = $this->flatrate ?? false;

        // Bereite die Daten für den Request vor
        $data = [
            'name'          => $this->name,
            'monthly_costs' => $this->monthly_costs,
            'flatrate'      => $flatrateValue,
            'services'      => $flatrateValue ? collect($this->tmpServices)->mapWithKeys(function($service) {
                return [$service['id'] => ['hours' => '']];
            })->toArray() : collect($this->tmpServices)->mapWithKeys(function($service) {
                return [$service['id'] => ['hours' => $this->serviceHours[$service['id']] ?? 0]];
            })->toArray(),
        ];

        // Speicher den Vertrag über den ContractController
        try{
            $contractController = app(ContractController::class);
            $contractController->store(new \Illuminate\Http\Request($data));

            session()->flash('message', __('app.contract_created_successfully'));
        }catch(\Exception $e){
            // Fehlerbehandlung
            session()->flash('error', __('app.create_contract_failed'));
        }
    }

    public function render() {
        return view('livewire.contracts.create')->layout('layouts.app');
    }
}
