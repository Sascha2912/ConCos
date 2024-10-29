<?php

namespace App\Livewire\Contracts;

use App\Models\Contract;

class Edit extends FormBase {

    public $contract;

    public function mount(Contract $contract) {
        $this->contract = $contract;
        $this->mountBase($contract); // Lädt den bestehenden Vertrag und die Services.

    }

    public function save() {
        $this->validateContract();

        $this->contract->update([
            'name'          => $this->name,
            'monthly_costs' => $this->monthly_costs,
            'flatrate'      => $this->flatrate,
        ]);

        // Prepare services with hours for the pivot table
        $servicesWithHours = [];
        foreach($this->tmpServices as $service){
            $servicesWithHours[$service['id']] = ['hours' => $this->serviceHours[$service['id']] ?? 0];
        }
        $this->contract->services()->sync($servicesWithHours);

        session()->flash('message', 'Contract updated successfully.');

        return redirect()->route('contracts.edit', $this->contract);
    }

    public function deleteContract() {
        $this->contract->delete();

        return redirect(route('contracts.index'));
    }

    public function render() {
        return view('livewire.contracts.edit')->layout('layouts.app');
    }
}
