<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

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
        View::composer(['layouts.app', 'layouts.app1', 'home', 'props.*'], function ($view) {
            try {
                $homeTypes = Schema::hasTable('hometypes')
                    ? DB::table('hometypes')->whereNull('deleted_at')->orderBy('hometypes')->get()
                    : collect();
            } catch (Throwable) {
                $homeTypes = collect();
            }

            $view->with('homeTypes', $homeTypes);
        });

        View::composer(['layouts.app', 'layouts.app1'], function ($view) {
            try {
                $featuredProps = Schema::hasTable('props')
                    ? DB::table('props')->latest()->limit(6)->get()
                    : collect();
            } catch (Throwable) {
                $featuredProps = collect();
            }

            $view->with('props', $featuredProps);
        });
    }
}
