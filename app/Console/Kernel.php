<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Register Artisan commands
     */
    protected $commands = [
        \App\Console\Commands\CheckLoanStatus::class,
    ];

    /**
     * Schedule commands
     */
    protected function schedule(Schedule $schedule): void
    {
        // 🔥 Run daily
        $schedule->command('loans:check-status')->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}