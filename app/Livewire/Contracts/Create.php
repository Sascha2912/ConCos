<?php

namespace App\Livewire\Contracts;

use App\Models\Contract;

class Create extends FormBase {
    public function mount() {
        $this->mountBase(); // Lädt die verfügbaren Services ohne einen bestehenden Vertrag.
    }

    public function save() {
        $this->validateContract();

        $flatrateValue = $this->flatrate ?? false;

        $contract = Contract::create([
            'name'          => $this->name,
            'monthly_costs' => $this->monthly_costs,
            'flatrate'      => $flatrateValue,
        ]);
        
        // Bereite Services mit den entsprechenden Stunden für die Pivot-Tabelle vor
        $servicesWithHours = [];
        foreach($this->tmpServices as $service){
            $servicesWithHours[$service['id']] = ['hours' => $this->serviceHours[$service['id']] ?? 0];
        }
        $contract->services()->sync($servicesWithHours);

        session()->flash('message', 'Contract created successfully.');

        return redirect()->route('contracts.edit', $contract);
    }

    public function render() {
        return view('livewire.contracts.create')->layout('layouts.app');
    }
}
