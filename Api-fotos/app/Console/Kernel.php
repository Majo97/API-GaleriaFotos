<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            \App\Models\Collection::where('deleted_at', '<=', now()->subMonth())->forceDelete();
            \App\Models\Image::where('deleted_at', '<=', now()->subMonth())->forceDelete();
            \App\Models\ActivityLog::where('created_at', '<=', now()->subMonth())->forceDelete();
            \App\Models\ActivityLog::where('update_at', '<=', now()->subMonth())->forceDelete();
        })->daily();
        
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
