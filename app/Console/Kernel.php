<?php

namespace App\Console;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:manage-leave')->yearly()->at('00:00');
        $schedule->command('app:manage-leave-half-day')->monthly()->at('00:00');
        $schedule->call(function () {
            $today = now()->toDateString();
            $usersClockedIn = Attendance::whereDate('clock_in', $today)->whereNull('clock_out')->get();
            foreach ($usersClockedIn as $timeClock) {
                $workingTimeInSeconds = \Illuminate\Support\Carbon::now('Asia/Dhaka')->diffInSeconds($timeClock->clock_in);
                $working_Time = gmdate('H:i:s',$workingTimeInSeconds);

                $timeClock->clock_out = Carbon::now();
                $timeClock->clock_out_date = $today;
                $timeClock->working_Time = $working_Time;
                $timeClock->save();
            }
        })->dailyAt('18:00');
    }
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
