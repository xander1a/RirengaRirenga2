<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        // Cap indexed string columns to 191 chars so utf8mb4 indexes fit
        // within the key-length limit on older MySQL/MariaDB (shared hosting).
        Schema::defaultStringLength(191);
    }
}
