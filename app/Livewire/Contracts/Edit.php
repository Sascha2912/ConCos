<?php

namespace App\Livewire\Contracts;

use App\Http\Controllers\ContractController;
use App\Models\Contract;
use App\Models\Service;
use Illuminate\Support\Facades\Http;

class Edit extends FormBase {

    public $contract;

    public function mount(Contract $contract) {
        $this->contract = $contract;
        $this->mountBase($contract);                               // Lädt den bestehenden Vertrag und die Services.
        $this->availableServices = Service::whereNotIn('id',
            array_column($this->tmpServices, 'id'))->get(); // Initialisiere die verfügbaren Services hier
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
            $contractController->update(new \Illuminate\Http\Request($data), $this->contract);

            session()->flash('message', __('app.contract_updated_successfully'));
        }catch(\Exception $e){
            // Fehlerbehandlung
            session()->flash('error', __('app.update_contract_failed'));
        }
    }

    public function deleteContract() {
        $contractController = app(ContractController::class);
        $contractController->destroy($this->contract);
    }

    public function render() {
        return view('livewire.contracts.edit')->layout('layouts.app');
    }
}
