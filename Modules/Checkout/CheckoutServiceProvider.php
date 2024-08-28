<?php

namespace Modules\Checkout;

use Illuminate\Support\ServiceProvider;

class CheckoutServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Cargar rutas del módulo
        $this->loadRoutesFrom('Modules/Checkout/Routes/api.php');

        // Cargar migraciones del módulo
        $this->loadMigrationsFrom('Modules/Checkout/Database/Migrations');
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
