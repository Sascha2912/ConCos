<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {
    /**
     * Define the application's command schedule.
     *
     * @param  Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        // Hier geplanten Aufgaben hinzufügen

        // Generiert am letzten Tag des Monats für jeden Kunden, einen PDF-Monatsbericht
        $schedule->command('report:generate-monthly')->monthlyOn(Carbon::now()->endOfMonth()->day, '00:00');
        // Jedes halbe Jahr werden alle PDF-Monatsberichte auf ihre existenz geprüft, wenn welche fehlen werden sie neu generiert
        if(in_array(now()->month, [1, 7])){
            $schedule->command('report:generate-historical-customer-monthly-reports')->monthlyOn(1, '00:00');
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
