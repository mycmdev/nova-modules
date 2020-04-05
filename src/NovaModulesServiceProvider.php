<?php

namespace Cmdev\NovaModules;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class NovaModulesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/nova-modules.php' => config_path('nova-modules.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(CommandsServiceProvider::class);

        $this->registerServices();
    }

    protected function registerServices()
    {
        $path = base_path(config('nova-modules.path'));

        $namespace = config('nova-modules.namespace');

        $dir = new \DirectoryIterator($path);


        foreach($dir as $module){
            if(!$module->isDot()){
                $module = $module->getBasename();
                $provider = $namespace."\\".$module."\\Providers\\".$module."ServiceProvider";

                $this->app->register($provider);

            }
        }


    }


}
