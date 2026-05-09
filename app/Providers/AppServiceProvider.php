<?php

namespace App\Providers;

use App\Models\Izin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Carbon::setLocale('id');

        Gate::define('admin', fn ($user) => $user->role_id === 1);

        View::composer(['admin.*', 'layouts.admin'], function ($view): void {
            $view->with('izinPendingCount', Izin::where('status', 'Pending')->count());
        });
    }
}
