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
            'hours'         => $this->hours,
            'monthly_costs' => $this->monthly_costs,
            'flatrate'      => $flatrateValue,
            'start_date'    => $this->start_date,
            'end_date'      => $this->end_date,
        ]);

        $serviceIds = array_column($this->tmpServices, 'id');
        $contract->services()->sync($serviceIds);

        session()->flash('message', 'Contract created successfully.');

        return redirect()->route('contracts.edit', $contract);
    }

    public function render() {
        return view('livewire.contracts.create')->layout('layouts.app');
    }
}
