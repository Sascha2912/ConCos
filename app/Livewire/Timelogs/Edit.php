<?php

namespace App\Livewire\Timelogs;

use App\Models\Timelog;
use Livewire\Component;

class Edit extends FormBase {

    public $timelog;
    public $customer_id;
    public $contract_id;
    public $service_id;

    public function mount(Timelog $timelog) {
        $this->timelog = $timelog;
        $this->customer_id = $timelog->customer->id;
        $this->contract_id = $timelog->contract->id;
        $this->service_id = $timelog->service->id;
        $this->mountBase($timelog);
        $this->loadCustomerData();
    }

    public function save() {
        $this->validateTimelog();

        $this->timelog->update([
            'customer_id' => $this->customer_id,
            'contract_id' => $this->contract_id,
            'service_id'  => $this->service_id,
            'hours'       => $this->hours,
            'date'        => $this->date,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Timelog updated successfully.');

        return redirect(route('timelogs.index', $this->customer_id));
    }

    public function loadCustomerData() {
        $customer = $this->timelog->customer;

        // Contracts und Services laden und Service-Contract-Zuordnung erstellen
        $this->contracts = $customer ? $customer->contracts : [];
        $this->services = $this->timelog->contract ? $this->timelog->contract->services : [];

        // Service-Contract-Zuordnung
        $this->serviceContractMap = $this->contracts->flatMap(function($contract) {
            return $contract->services->mapWithKeys(function($service) use ($contract) {
                return [$service->id => $contract->id];
            });
        })->toArray();

        $this->selectedServiceId = $this->timelog->service_id;
        $this->selectedContractId = $this->timelog->contract_id;
    }

    public function updatedSelectedServiceId($serviceId) {
        // Wähle den passenden Contract basierend auf dem ausgewählten Service
        $this->selectedContractId = $this->serviceContractMap[$serviceId] ?? null;
    }

    public function deleteTimelog() {
        $this->timelog->delete();

        return redirect(route('timelogs.index', $this->customer_id));
    }

    public function render() {
        return view('livewire.timelogs.edit', [
            'contracts' => $this->contracts,
            'services'  => $this->services,
        ])->layout('layouts.app');
    }
}
