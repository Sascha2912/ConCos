<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class GenerateMonthlyReports extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:generate-monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates and stores monthly reports for each customer on the last day of the month';

    /**
     * Execute the console command.
     */
    public function handle() {
        $date = Carbon::now()->subMonth(); // Generierung für den letzten Monat
        $year = $date->year;
        $month = $date->month;

        $customers = Customer::all();

        foreach($customers as $customer){
            // Erstelle den PDF-Bericht mit Daten
            $reportData = $this->generateReportData($customer, $month, $year);

            $pdf = Pdf::loadView('reports.monthly', [
                'reportData' => $reportData,
                'customer'   => $customer,
                'month'      => $month,
                'year'       => $year,
                'totalCost'  => $reportData['totalCost'],
            ])->setPaper('a4', 'portrait');

            // Speicerpfad für den Kundenordner
            $customerFolder = "reports/{$customer->name}";

            // Ordner erstellen, falls er nicht existiert
            Storage::makeDirectory($customerFolder);

            // Speicherpfad und Dateiname
            $fileName = "{$customerFolder}/{$year}_{$month}_{$customer->id}_monthly_report.pdf";

            // PDF Speichern
            Storage::put($fileName, $pdf->output());

            $this->info("Report for Customer ID {$customer->id} saved as {$fileName}");
        }
    }

    protected function generateReportData($customer, $month, $year) {
        // Erstelle die Report-Daten ähnlich wie in der Livewire-Komponente `loadMonthlyReport()`
        $reportData = [];
        $totalCost = 0;
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        foreach($customer->contracts as $contract){
            $contractData = [
                'contract_name'       => $contract->name,
                'monthly_costs'       => $contract->monthly_costs,
                'services'            => [],
                'contract_total_cost' => 0,
            ];

            $contractTotalCost = $contract->monthly_costs;

            foreach($contract->services as $service){
                $timelogHours = $customer->timelogs()
                    ->where('contract_id', $contract->id)
                    ->where('service_id', $service->id)
                    ->whereBetween('date', [$startDate, $endDate])
                    ->sum('hours');

                $additionalHours = max(0, $timelogHours - $service->pivot->hours);
                $additionalCost = $additionalHours * $service->costs_per_hour;

                $contractData['services'][] = [
                    'service_name'     => $service->name,
                    'agreed_hours'     => $service->pivot->hours,
                    'used_hours'       => $timelogHours,
                    'additional_hours' => $additionalHours,
                    'additional_cost'  => $additionalCost,
                    'costs_per_hour'   => $service->costs_per_hour,
                ];

                $contractTotalCost += $additionalCost;
            }

            $contractData['contract_total_cost'] = $contractTotalCost;
            $reportData['contracts'][] = $contractData;
            $totalCost += $contractTotalCost;
        }

        $reportData['totalCost'] = $totalCost;

        return $reportData;
    }
}
