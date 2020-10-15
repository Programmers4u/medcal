<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Illuminate\Contracts\Auth\Registrar::class,
            \App\TG\Registrar::class
        );

        if ($this->app->environment() == 'local') {
            $this->app->register(\Laracasts\Generators\GeneratorsServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            // $this->app->register(\Potsky\LaravelLocalizationHelpers\LaravelLocalizationHelpersServiceProvider::class);
        }

        if (config('services.rollbar.access_token', false)) {
            $this->app->register(\Jenssegers\Rollbar\RollbarServiceProvider::class);
        }
        
        if (!Collection::hasMacro('paginate')) {

                Collection::macro('paginate', 
                    function ($perPage = 15, $page = null, $options = []) {
                    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                    return (new LengthAwarePaginator(
                        $this->forPage($page, $perPage), $this->count(), $perPage, $page, $options));
                        //->withPath('');
                });
        }        
    }
}
