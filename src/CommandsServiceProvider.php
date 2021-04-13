<?php

namespace Cmdev\NovaModules;

use Illuminate\Support\ServiceProvider;

class CommandsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            'Cmdev\NovaModules\Commands\MakeModuleCommand',
            'Cmdev\NovaModules\Commands\MakeResourceCommand',
            'Cmdev\NovaModules\Commands\MakeLensCommand',
            'Cmdev\NovaModules\Commands\MakeActionCommand',
            'Cmdev\NovaModules\Commands\MakePartitionCommand',
            'Cmdev\NovaModules\Commands\MakeValueCommand',
            'Cmdev\NovaModules\Commands\MakeTrendCommand',
            'Cmdev\NovaModules\Commands\MakeMigrationCommand',
            'Cmdev\NovaModules\Commands\MakeFilterCommand',
            'Cmdev\NovaModules\Commands\MakeCustomFilterCommand',
            'Cmdev\NovaModules\Commands\MakeCardCommand',
            'Cmdev\NovaModules\Commands\MakeDashboardCommand',
            'Cmdev\NovaModules\Commands\MakeFieldCommand',
            'Cmdev\NovaModules\Commands\MakeResourceToolCommand',
            'Cmdev\NovaModules\Commands\MakeToolCommand',
            'Cmdev\NovaModules\Commands\MakeModelCommand',
            'Cmdev\NovaModules\Commands\MakeProviderCommand',
            'Cmdev\NovaModules\Commands\SeederCommand',
            'Cmdev\NovaModules\Commands\MakePolicyCommand'
        ]);
    }

    public function boot()
    {

    }
}
