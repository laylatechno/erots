<?php
namespace App\Providers;

use App\Models\Profil;
use App\Models\User;
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
        // Share the profil data with all views
        $profil = Profil::where('id', 1)->first();
        View::share('profil', $profil);

        // Share the count of non-active users with all views
        $nonActiveUserCount = User::where('status', 'Non Aktif')->count();
        View::share('nonActiveUserCount', $nonActiveUserCount);

        $users = User::all();
        View::share('users', $users);
    }
}

