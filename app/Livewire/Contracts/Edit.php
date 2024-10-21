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
            'hours'         => $this->hours,
            'monthly_costs' => $this->monthly_costs,
            'flatrate'      => $this->flatrate,
            'start_date'    => $this->start_date,
            'end_date'      => $this->end_date,
        ]);

        $serviceIds = array_column($this->tmpServices, 'id');
        $this->contract->services()->sync($serviceIds);

        session()->flash('message', 'Contract updated successfully.');

        return redirect()->route('contracts.edit', $this->contract);
    }

    public function render() {
        return view('livewire.contracts.edit')->layout('layouts.app');
    }
}
