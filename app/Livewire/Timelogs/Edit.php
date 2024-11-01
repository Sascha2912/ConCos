<?php

namespace App\Livewire\Timelogs;

use App\Http\Controllers\TimelogController;
use App\Models\Customer;
use App\Models\Timelog;
use Livewire\Component;

class Edit extends FormBase {

    public $timelog;
    public $customer;

    public function mount(Customer $customer, Timelog $timelog) {
        $this->customer = $customer;
        $this->customer_id = $customer->id;
        $this->timelog = $timelog;

        $this->mountBase($timelog);
        $this->loadCustomerData();

        $this->selectedContractId = $timelog->contract_id;
        $this->selectedServiceId = $timelog->service_id;
        $this->hours = $timelog->hours;
        $this->date = $timelog->date;
        $this->description = $timelog->description;
    }

    public function save() {
        $this->validateTimelog();

        // Sammeln der aktualisierten Daten für das Timelog
        $data = [
            'customer_id' => $this->customer_id,
            'contract_id' => $this->selectedContractId,
            'service_id'  => $this->selectedServiceId,
            'hours'       => $this->hours,
            'date'        => $this->date,
            'description' => $this->description,
        ];

        // Aufruf des TimelogControllers zur Aktualisierung
        try{
            $timelogController = app(TimelogController::class);
            $timelogController->update(new \Illuminate\Http\Request($data), $this->timelog);

            session()->flash('message', __('app.timelog_updated_successfully'));
        }catch(\Exception $e){
            // Fehlerbehandlung
            session()->flash('error', __('app.update_timelog_failed'));
        }
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
        $timelogController = app(TimelogController::class);
        $timelogController->destroy($this->timelog, $this->customer_id);

    }

    public function render() {
        return view('livewire.timelogs.edit', [
            'contracts' => $this->contracts,
            'services'  => $this->services,
        ])->layout('layouts.app');
    }
}
