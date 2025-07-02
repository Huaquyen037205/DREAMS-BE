<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();
        View::composer('template.admin', function ($view) {
        $today = Carbon::today();
        $notifications = Notification::whereDate('created_at', $today)
        ->orderByDesc('created_at')
        ->take(10)
        ->get();
        $unreadCount = Notification::where('status', 'unread')->count();
        $view->with('notifications', $notifications)->with('unreadCount', $unreadCount);
    });
    }
}
