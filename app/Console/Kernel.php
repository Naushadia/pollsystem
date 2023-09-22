<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\PersonalAccessToken;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('sanctum:prune-expired --hours=24')->daily();
    }
    // protected function schedule(Schedule $schedule)
    // {
    //     $schedule->call(function () {
    //         $expiration = config('sanctum.expiration');
    //         PersonalAccessToken::where('created_at', '<', Carbon::now()->subMinutes($expiration))->delete();
    //     })->everyMinute();
    // }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
