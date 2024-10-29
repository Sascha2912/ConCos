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
    public $reportData = [];

    public function mount($customerId, $month, $year) {
        $this->customer = Customer::findOrfail($customerId);
        $this->month = $month;
        $this->year = $year;
        $this->loadMonthlyReport();
    }

    public function loadMonthlyReport() {
        $starDate = Carbon::create($this->year, $this->month, 1)->startOfMonth();
        $endDate = Carbon::create($this->year, $this->month, 1)->endOfMonth();

        $this->reportData = [];

        foreach($this->customer->contracts as $contract){
            $contractData = [
                'contract_name' => $contract->name,
                'monthly_costs' => $contract->monthly_cost,
                'services'      => [],
            ];

            foreach($contract->services as $service){
                $timelogHours = $this->customer->timelogs()
                    ->where('contract_id', $contract->id)
                    ->where('service_id', $service->id)
                    ->whereBetween('date', [$starDate, $endDate])
                    ->sum('hours');

                $additionalHours = max(0, $timelogHours - $service->pivot->hours);
                $additionalCost = $additionalHours * $service->costs_per_hour;

                $contractData['services'][] = [
                    'service_name'     => $service->name,
                    'agreed_hours'     => $service->pivot->hours,
                    'used_hours'       => $timelogHours,
                    'additional_hours' => $additionalHours,
                    'additional_cost'  => $additionalCost,
                ];
            }

            $this->reportData['contracts'][] = $contractData;
        }
    }

    public function downloadPdf() {
        $pdf = Pdf::loadView('reports.monthly', [
            'reportData' => $this->reportData,
            'customer'   => $this->customer,
            'month'      => $this->month,
            'year'       => $this->year,
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
