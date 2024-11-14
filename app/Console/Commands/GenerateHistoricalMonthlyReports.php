<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Traits\ReportsHelperTrait;

class GenerateHistoricalMonthlyReports extends Command {
    use ReportsHelperTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:generate-historical-customer-monthly-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates and stores missing monthly reports for each customer based on their earliest contract date, but only if costs are greater than zero';

    /**
     * Execute the console command.
     */
    public function handle() {
        $customers = Customer::all();

        foreach($customers as $customer){
            // Ermittel das früheste Vertragsdatum für diesen Kunden
            $earliestCreateDate = $customer->contracts()->min('contract_customer.create_date');

            if( !$earliestCreateDate){
                $this->info("Customer ID {$customer->id} has no contracts. Skipping");
            }

            $startDate = Carbon::parse($earliestCreateDate)->startOfMonth();
            $currentDate = now()->startOfMonth();

            while($startDate <= $currentDate){
                $year = $startDate->year;
                $month = $startDate->month;

                $customerName = str_replace(' ', '_', $customer->name);
                $customerName = str_replace('-', '_', $customerName);
                $customerName = preg_replace('/[.,]/', '', $customerName);

                $filename = "reports/{$customerName}/{$year}/{$month}_{$customer->id}_monthly_report.pdf";

                // Bericht überspringen, falls bereits vorhanden
                if(Storage::exists($filename)){
                    $this->info("Report for Customer ID {$customer->id} in {$year}-{$month} already exists. Skipping.");
                    $startDate->addMonth();
                    continue;
                }

                // Generiere Report-Daten
                $reportData = $this->generateReportData($customer, $month, $year);

                // Berichte nur erstellen, wenn Kosten > 0
                if($reportData['totalCost'] > 0){
                    $pdf = Pdf::loadView('reports.monthly', [
                        'reportData' => $reportData,
                        'customer'   => $customer,
                        'month'      => $month,
                        'year'       => $year,
                        'totalCost'  => $reportData['totalCost'],
                    ])->setPaper('a4', 'portrait');

                    $customerFolder = "reports/{$customerName}/{$year}";
                    Storage::makeDirectory($customerFolder);

                    Storage::put($filename, $pdf->output());
                    $this->info("Report for Customer ID {$customer->id} saved as {$filename}");
                }else{
                    $this->info("Report for Customer ID {$customer->id} in {$year}-{$month} has no costs. Skipping");
                }

                // Gehe zum nächsten Monat
                $startDate->addMonth();
            }
        }
    }
}
