<?php

namespace App\Providers;

use App\Models\Place;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\Telescope;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar Telescope solo si NO estamos ejecutando tests y si estamos en entorno local
        // o si la variable de entorno TELESCOPE_ENABLED está activada.
        // Esto evita que Telescope se cargue durante la suite de pruebas.
        if (! $this->app->runningUnitTests() && ($this->app->isLocal() || env('TELESCOPE_ENABLED', false))) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'tour' => Tour::class,
            'place' => Place::class,
        ]);
    }
}
