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
        // Hier die geplanten Aufgaben hinzufügen
        // Geplanten Command hinzufügen, der am letzten Tag des Monats um Mitternacht ausgeführt wird
        $schedule->command('reports:generate-monthly')->monthlyOn(Carbon::now()->endOfMonth()->day, '00:00');
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
