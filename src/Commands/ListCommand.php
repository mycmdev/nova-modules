<?php


namespace Cmdev\NovaModules\Commands;


use Illuminate\Console\Command;

class ListCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nova-modules:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Return list of all available resources.';

    public function handle()
    {
        $path = base_path(config('nova-modules.path'));

        $namespace = config('nova-modules.namespace');

        $dir = new \DirectoryIterator($path);


        foreach($dir as $module){
            if(!$module->isDot()){
                $novaModule = $module->getBasename();

                $resourceDir = new \DirectoryIterator($path."/".$novaModule."/resources");
                foreach($resourceDir as $resource){
                    if(!$resource->isDot()){
                        $this->line($resource->getBasename());
                    }
                }
            }
        }


    }
}
