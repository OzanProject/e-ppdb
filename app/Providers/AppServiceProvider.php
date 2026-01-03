<?php

namespace App\Providers;

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
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        // Share 'school' variable globally with all views
        try {
            $school = \App\Models\School::first();
            \Illuminate\Support\Facades\View::share('school', $school);
        } catch (\Exception $e) {
            // Ignored during migration
        }
    }
}
