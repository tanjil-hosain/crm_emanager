<?php
namespace App\Providers;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // dd(auth()->user()->getRoleNames());
        // Admin will get full access
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        // Global Setting
        View::composer('*', function ($view) {
            $view->with('setting', Setting::first());
        });
         Paginator::useBootstrapFive();
    }
}
