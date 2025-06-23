<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    // Đăng ký command tại đây
    protected $commands = [
        \App\Console\Commands\SendBirthdayCoupon::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Đổi dailyAt('08:00') thành everyMinute() để test nhanh
        $schedule->command('coupon:birthday')->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
