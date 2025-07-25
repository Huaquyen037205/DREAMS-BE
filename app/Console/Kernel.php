<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SendBirthdayCoupon::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // 🎯 Mỗi ngày lúc 08:00 sáng hệ thống tự động chạy
        $schedule->command('coupon:birthday')
            ->dailyAt('08:00')
            ->timezone('Asia/Ho_Chi_Minh') // đảm bảo đúng giờ Việt Nam
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/birthday_coupon.log')); // ghi log nếu cần
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
