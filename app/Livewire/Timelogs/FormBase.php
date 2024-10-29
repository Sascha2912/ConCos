<?php

namespace App\Livewire\Timelogs;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Timelog;
use Livewire\Component;

abstract class FormBase extends Component {

    public $customer_id;

    public $contracts = [];
    public $services = [];
    public $selectedContractId = null;
    public $selectedServiceId = null;

    public $description;
    public $hours;
    public $date;

    public function mountBase($timelog = null) {
        if($timelog){
            $this->customer_id = $timelog->customer->id;
            $this->hours = $timelog->hours;
            $this->date = $timelog->date;
            $this->description = $timelog->description;
        }
    }

    public function loadContracts() {
        $customer = Customer::find($this->customer_id);

        $this->contracts = $customer->contracts()->get();


        $this->reset(['selectedContractId', 'services', 'selectedServiceId']);
    }

    public function loadServices() {
        if($this->selectedContractId){
            $this->services = Service::whereHas('contracts', function($query) {
                $query->where('contracts.id', $this->selectedContractId);
            })->get();
            $this->selectedServiceId = null;
        }
    }

    public function validateTimelog() {
        $this->validate([
            'customer_id'        => 'required|integer|exists:customers,id',
            'selectedContractId' => 'required|integer|exists:contracts,id',
            'selectedServiceId'  => 'required|integer|exists:services,id',
            'hours'              => 'required|integer|between:1,24',
            'date'               => 'required|date',
            'description'        => 'nullable|string|max:999',
        ]);
    }

    abstract public function save(); // Muss von den abgeleiteten Klassen implementiert werden.
}
