<?php

namespace App\Providers;

use App\Models\rwModel;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;


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
        // Check if the table exists before trying to access it
        if (Schema::hasTable('rw')) {
            $rws = Cache::remember('rws', 600, function () {
                return rwModel::all();
            });

            View::share('rws', $rws);
        } else {
            View::share('rws', collect());
        }
    }
}
