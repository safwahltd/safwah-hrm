<?php

namespace App\Providers;

use App\Models\Notice;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        View::composer(['*'],function ($view){
            $view->with([
                'setting' => Setting::first(),
            ]);
        });
        View::composer(['admin.layout.app'],function ($view){
            $view->with([
//                'company' => Setting::first(),
                'notices' => Notice::where('status',1)->whereDate('start_date', '<=', now())->where(function($query) {$query->whereNull('end_date')->orWhere('end_date', '>=', now());})->orderBy('created_at', 'desc')->latest()->take(10)->get(),
                'noticeCount' => Notice::where('status',1)->whereDate('start_date', '<=', now())->where(function($query) {$query->whereNull('end_date')->orWhere('end_date', '>=', now());})->count(),
                'notifications' => auth()->user()->notifications()->latest()->take(5)->get(),
            ]);
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
