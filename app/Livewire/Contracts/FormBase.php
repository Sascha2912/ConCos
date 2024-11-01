<?php

namespace App\Livewire\Contracts;

use App\Http\Controllers\ContractController;
use App\Models\Service;
use Livewire\Component;

abstract class FormBase extends Component {

    public $name;
    public $monthly_costs;
    public $flatrate;
    public $tmpServices = [];
    public $serviceHours = [];      // Stunden für jeden Service
    public $availableServices = []; // Initialisiert als leeres Array
    public $selectedServiceId = null;

    public function mountBase($contract = null) {
        if($contract){
            $this->name = $contract->name;
            $this->monthly_costs = $contract->monthly_costs;
            $this->flatrate = $contract->flatrate;

            $this->tmpServices = $contract->services()->withPivot('hours')->get()->map(function($service) {
                return [
                    'id'    => $service->id,
                    'name'  => $service->name,
                    'hours' => $service->pivot->hours, // Lade die Stunden aus der Pivot-Tabelle
                ];
            })->toArray();
            $this->availableServices = Service::whereNotIn('id', array_column($this->tmpServices, 'id'))->get();

            // Setze $selectedServiceId auf null, wenn ein Vertrag geladen wird
            $this->selectedServiceId = null; // Oder setze es auf den Wert des gewünschten Services, wenn du einen Default-Wert haben möchtest
        }

        // Initialisiere die Stunden für jeden Service im Array $serviceHours
        foreach($this->tmpServices as $service){
            $this->serviceHours[$service['id']] = $service['hours'];
        }
    }

    public function addService($serviceId) {
        $service = Service::find($serviceId);
        if($service && !in_array($serviceId, array_column($this->tmpServices, 'id'))){
            $this->tmpServices[] = $service->toArray();
            $this->availableServices = $this->availableServices->filter(function($s) use ($serviceId) {
                return $s->id != $serviceId;
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

    public function validateContract() {
        $this->validate([
            'name'          => 'required|bail|string|max:255',
            'monthly_costs' => 'nullable|numeric',
            'flatrate'      => 'nullable|boolean',
        ]);
    }

    abstract public function save(); // Muss von den abgeleiteten Klassen implementiert werden.
}