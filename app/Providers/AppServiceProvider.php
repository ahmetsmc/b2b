<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Pagination\Paginator;

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
        Schema::defaultStringLength(191);
        date_default_timezone_set('Europe/Istanbul');
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, LaravelLocalization::getCurrentLocaleRegional());
        Paginator::defaultView('vendor.pagination.default');
        Paginator::defaultSimpleView('vendor.pagination.default');

        if (config('app.url') == "http://localhost:8000"){
            Mail::alwaysTo('ahmetalpersam@gmail.com');
        }
    }
}
