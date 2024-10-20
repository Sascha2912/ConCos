<?php

namespace App\Livewire\Contracts;

use App\Models\Contract;
use App\Models\Service;
use Livewire\Component;

class Edit extends Component {

    public $contract;
    public $name;
    public $hours;
    public $monthly_costs;
    public $flatrate;
    public $start_date;
    public $end_date;
    public $tmpServices = [];
    public $availableServices;
    public $selectedServiceId = [];

    public function mount(Contract $contract) {
        $this->contract = $contract;
        $this->name = $contract->name;
        $this->hours = $contract->hours;
        $this->monthly_costs = $contract->monthly_costs;
        $this->flatrate = $contract->flatrate;
        $this->start_date = $contract->start_date;
        $this->end_date = $contract->end_date;

        $this->tmpServices = $contract->services->toArray();

        $this->availableServices = Service::whereNotIn('id', array_column($this->tmpServices, 'id'))->get();
    }

    public function addService($serviceId) {
        $service = Service::find($serviceId);
        if($service && !in_array($serviceId, array_column($this->tmpServices, 'id'))){
            $this->tmpServices[] = $service->toArray();

            $this->availableServices = $this->availableServices->filter(function($service) use ($serviceId) {

                return $service->id != $serviceId;
            });

            $this->reset('selectedServiceId');
        }
    }

    public function removeService($serviceId) {
        $this->tmpServices = array_filter($this->tmpServices, function($service) use ($serviceId) {

            return $service['id'] != $serviceId;
        });

        $service = Service::find($serviceId);
        if($service && !$this->availableServices->contains('id', $serviceId)){
            $this->availableServices->push($service);
        }
    }

    public function save() {
        $this->validate([
            'name'          => 'required|bail|string|max:255',
            'hours'         => 'nullable|int',
            'monthly_costs' => 'nullable|numeric',
            'flatrate'      => 'nullable|boolean',
            'start_date'    => 'required|bail|date',
            'end_date'      => 'nullable|date',
        ]);

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

    public function deleteContract($contractId) {
        $contract = Contract::findOrFail($contractId);

        // Löschaktion durchführen
        $contract->delete();

        // Optional: Weiterleitung nach dem Löschen
        return redirect()->route('contracts.index')->with('message', 'Contract deleted successfully.');
    }

    public function render() {
        return view('livewire.contracts.edit')->layout('layouts.app');
    }
}
