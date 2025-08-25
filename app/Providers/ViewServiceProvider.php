<?php

namespace App\Providers;

use App\Models\rwModel;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       $rws = Cache::remember('rws', 600, function () {
        return rwModel::all();
    });

    View::share('rws', $rws);
    }
}
