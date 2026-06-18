<?php

namespace App\Providers;

use App\Models\Transaction;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        view()->composer('layouts.admin', function ($view) {
            $view->with('pendingTransactionCount', Transaction::where('payment_status', 'pending')->count());
        });
    }
}
