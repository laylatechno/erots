<?php

namespace App\Providers;

use App\Models\Profil;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        //
        $profil = Profil::where('id', 1)->first();
        View::share('profil', $profil);
    }
}
