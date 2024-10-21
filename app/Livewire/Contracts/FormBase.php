<?php

namespace App\Livewire\Contracts;

use App\Models\Service;
use Livewire\Component;

abstract class FormBase extends Component {

    public $name;
    public $hours;
    public $monthly_costs;
    public $flatrate;
    public $start_date;
    public $end_date;
    public $tmpServices = [];
    public $availableServices;
    public $selectedServiceId = null;

    public function mountBase($contract = null) {
        if($contract){
            $this->name = $contract->name;
            $this->hours = $contract->hours;
            $this->monthly_costs = $contract->monthly_costs;
            $this->flatrate = $contract->flatrate;
            $this->start_date = $contract->start_date;
            $this->end_date = $contract->end_date;

            $this->tmpServices = $contract->services->toArray();
            $this->availableServices = Service::whereNotIn('id', array_column($this->tmpServices, 'id'))->get();
        }else{
            // Falls es keinen Vertrag gibt, sind alle Services verfügbar.
            $this->availableServices = Service::all();
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
            'hours'         => 'nullable|int',
            'monthly_costs' => 'nullable|numeric',
            'flatrate'      => 'nullable|boolean',
            'start_date'    => 'required|bail|date',
            'end_date'      => 'nullable|date',
        ]);
    }

    abstract public function save(); // Muss von den abgeleiteten Klassen implementiert werden.
}