<?php

namespace App\Providers;

use App\Models\Loja;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Lojas', function()
        {
            $lojas = Loja::all();

            foreach ($lojas as $loja)
            {
                $baseDados = config("database.connections.mysql");
                $baseDados['database'] = $loja->base_dados_nome;
                config(["database.connections.{$loja->base_dados_nome}" => $baseDados]);
            }
            return $lojas;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
