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
        /*View::composer(['*'],function ($view){
            $view->with([
//                'company' => Setting::first(),
                'notices' => Notice::whereDate('start_date', '<=', now())->where(function($query) {$query->whereNull('end_date')->orWhere('end_date', '>=', now());
            })->orderBy('created_at', 'desc')->get(),
            ]);
        });*/
        View::composer(['employee.layout.app'],function ($view){
            $view->with([
//                'company' => Setting::first(),
                'notices' => Notice::where('status',1)->whereDate('start_date', '<=', now())->where(function($query) {$query->whereNull('end_date')->orWhere('end_date', '>=', now());
            })->orderBy('created_at', 'desc')->latest()->take(10)->get(),
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
