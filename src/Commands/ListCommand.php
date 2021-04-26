<?php


namespace Cmdev\NovaModules\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\ActionResource;
use Laravel\Nova\Resource;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

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

        $resources = [];

        foreach($dir as $module){
            if(!$module->isDot()){
                $novaModule = $module->getBasename();

                $directory = $path . '/' . $novaModule;
                $namespace = $namespace."\\".$novaModule;

                foreach ((new Finder)->in($directory)->files() as $resource) {
                    $resource = str_replace(
                        '.php',
                        '',
                        $namespace."\\Resources\\".Str::afterLast($resource, '\\')
                    );

                    if (is_subclass_of($resource, Resource::class) &&
                        ! (new ReflectionClass($resource))->isAbstract() &&
                        ! (is_subclass_of($resource, ActionResource::class))) {
                        $resources[] = $resource;
                    }
                }
            }
        }

        foreach($resources as $resource){
            $this->line($resource);
        }


    }
}
