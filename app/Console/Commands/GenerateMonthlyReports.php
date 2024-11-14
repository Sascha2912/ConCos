<?php

namespace App\Console\Commands;

use App\Traits\ReportsHelperTrait;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class GenerateMonthlyReports extends Command {
    use ReportsHelperTrait;

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
            $customerName = str_replace(' ', '_', $customer->name);
            $customerName = str_replace('-', '_', $customerName);
            $customerName = preg_replace('/[.,]/', '', $customerName);

            // Speicherpfad für den Kundenordner
            $customerFolder = "reports/{$customerName}/{$year}";
            // Speicherpfad und Dateiname
            $fileName = "reports/{$customerName}/{$year}/{$month}_{$customer->id}_monthly_report.pdf";

            // Überspringe die Berichterstellung, wenn der Bericht bereits existiert
            if(Storage::exists($fileName)){
                $this->info("Report for Customer ID {$customer->id} in {$year}-{$month} already exists. Skipping.");
                continue;
            }

            // Erstelle den PDF-Bericht mit Daten
            $reportData = $this->generateReportData($customer, $month, $year);

            // Erstelle den PDF-Bericht, falls `totalCost > 0`
            if($reportData['totalCost'] > 0){
                $pdf = Pdf::loadView('reports.monthly', [
                    'reportData' => $reportData,
                    'customer'   => $customer,
                    'month'      => $month,
                    'year'       => $year,
                    'totalCost'  => $reportData['totalCost'],
                ])->setPaper('a4', 'portrait');

                // Erstelle den Ordner, falls er nicht existiert
                Storage::makeDirectory($customerFolder);

                // Speichere das PDF
                Storage::put($fileName, $pdf->output());
                $this->info("Report for Customer ID {$customer->id} saved as {$fileName}");
            }else{
                $this->info("No costs for Customer ID {$customer->id} in {$year}-{$month}. Report not generated.");
            }
        }
    }
}
