<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;

class MonthlyReport extends Component {

    public $customer;
    public $month;
    public $year;

    public $currentYear;
    public $reportData = [];
    public $totalCost = 0;
    public $availableYears = []; // Verfügbare Jahre für die Dropdown-Auswahl

    public function mount($customerId) {
        $this->customer = Customer::findOrfail($customerId);

        // Setze den aktuellen Monat und das Jahr als Standardwerte
        $this->month = now()->month;
        $this->year = now()->year;

        $earliestCreateDate = $this->customer->contracts()
            ->withPivot('create_date')
            ->min('contract_customer.create_date');

        if($earliestCreateDate){
            $earliestContractCustomerCreatedYear = \Carbon\Carbon::parse($earliestCreateDate)->year;
        }else{
            $earliestContractCustomerCreatedYear = null; // oder ein anderer Standardwert
        }

        $this->currentYear = now()->year;
        $this->availableYears = range($earliestContractCustomerCreatedYear, $this->currentYear);

        $this->loadMonthlyReport();
    }

    public function loadMonthlyReport() {
        $starDate = Carbon::create($this->year, $this->month, 1)->startOfMonth();
        $endDate = Carbon::create($this->year, $this->month, 1)->endOfMonth();

        $this->reportData = [];
        $this->totalCost = 0; // Gesamtkosten auf 0 setzen, um Duplikationen zu vermeiden

        foreach($this->customer->contracts as $contract){
            // Basis-Vertragsdaten
            $contractData = [
                'contract_name' => $contract->name,
                'monthly_costs' => $contract->monthly_costs,
                'services'      => [],
            ];

            // Setze die Vertragskosten für diesen Vertrag in einer separaten Variable
            $contractTotalCost = $contract->monthly_costs;

            // Erstellen eines Maps, um Duplikate zu vermeiden
            $servicesMap = [];

            if($contract->name === '-'){

                foreach($contract->services as $service){

                    $timelogHours = $this->customer->timelogs()
                        ->where('contract_id', $contract->id)
                        ->where('service_id', $service->id)
                        ->whereBetween('date', [$starDate, $endDate])
                        ->sum('hours');

                    if($timelogHours > 0){
                        $additionalHours = max(0, $timelogHours - $service->pivot->hours);
                        $additionalCost = $additionalHours * $service->costs_per_hour;

                        // Füge nur hinzu, wenn der Service nicht bereits in servicesMap ist
                        if( !isset($servicesMap[$service->id])){
                            $servicesMap[$service->id] = [
                                'service_name'     => $service->name,
                                'agreed_hours'     => $service->pivot->hours,
                                'used_hours'       => $timelogHours,
                                'additional_hours' => $additionalHours,
                                'additional_cost'  => $additionalCost,
                                'costs_per_hour'   => $service->costs_per_hour,
                            ];

                            // Zusatzkosten zu den Vertragsgesamtkosten hinzufügen
                            $contractTotalCost += $additionalCost;
                        }
                    }
                }

            }else{
                foreach($contract->services as $service){

                    $timelogHours = $this->customer->timelogs()
                        ->where('contract_id', $contract->id)
                        ->where('service_id', $service->id)
                        ->whereBetween('date', [$starDate, $endDate])
                        ->sum('hours');
                    if( !$contract->flatrate){


                        $additionalHours = max(0, $timelogHours - $service->pivot->hours);
                        $additionalCost = $additionalHours * $service->costs_per_hour;

                        // Füge nur hinzu, wenn der Service nicht bereits in servicesMap ist
                        if( !isset($servicesMap[$service->id])){
                            $servicesMap[$service->id] = [
                                'service_name'     => $service->name,
                                'agreed_hours'     => $service->pivot->hours,
                                'used_hours'       => $timelogHours,
                                'additional_hours' => $additionalHours,
                                'additional_cost'  => $additionalCost,
                                'costs_per_hour'   => $service->costs_per_hour,
                            ];

                            // Zusatzkosten zu den Vertraggesamtkosten hinzufügen
                            $contractTotalCost += $additionalCost;
                        }
                    }else{

                        // Flatrate-Handling: nur einmalig hinzufügen, falls noch nicht vorhanden
                        if( !isset($servicesMap[$service->id])){
                            $servicesMap[$service->id] = [
                                'service_name'     => $service->name,
                                'agreed_hours'     => 'flatrate',
                                'used_hours'       => $timelogHours,
                                'additional_hours' => 0,
                                'additional_cost'  => 0,
                                'costs_per_hour'   => $service->costs_per_hour,
                            ];

                            // Zusatzkosten zu den Vertraggesamtkosten hinzufügen
                            $contractTotalCost = 0;
                        }
                    }
                }
            }

            //Speichern der Gesamtkosten für diesen Vertrag in 'contractData
            $contractData['contract_total_cost'] = $contractTotalCost;

            // Füge alle Services aus servicesMap zu contractData['services'] hinzu
            $contractData['services'] = array_values($servicesMap);

            // Füge die Vertragsdaten dem Report hinzu
            $this->reportData['contracts'][] = $contractData;
            // Nur einmal die berechneten Gesamtkosten des Vertrags zu den totalen Gesamtkosten hinzufügen
            $this->totalCost += $contractTotalCost;
        }
    }

    public function setMonth($month) {
        $this->month = $month;
        $this->loadMonthlyReport();
    }

    public function downloadPdf() {
        $pdf = Pdf::loadView('reports.monthly', [
            'reportData' => $this->reportData,
            'customer'   => $this->customer,
            'month'      => $this->month,
            'year'       => $this->year,
            'totalCost'  => $this->totalCost,
        ])->setPaper('a4', 'portrait')
            ->setWarnings(false)
            ->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);;

        return response()->streamDownload(
            fn() => print($pdf->output()),
            __('app.monthly_report_for')."_{$this->customer->name}_{$this->month}_{$this->year}.pdf",
        );
    }

    public function render() {
        return view('livewire.customers.monthly-report')->layout('layouts.app');
    }
}
