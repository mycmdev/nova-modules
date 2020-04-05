<?php


namespace Cmdev\NovaModules\Commands;


use Cmdev\NovaModules\Helpers\ModuleGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeResourceCommand extends ModuleGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nova-modules:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new resource.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $module = $this->argument('module');

        $resource = $this->argument('resource');

        $studlyModule = Str::studly($module);

        $studlyResource = Str::studly($resource);

        $namespace = $this->namespace();

        $resourceModel = "$namespace\\Models\\$studlyResource";

        $template = str_replace([
            '{{resourceName}}',
            '{{namespace}}',
            '{{resourceModel}}',
            '{{moduleName}}'
        ],[
            $studlyResource,
            $namespace,
            $resourceModel,
            $studlyModule
        ], $this->getStub('Resource'));

        file_put_contents($this->dir($studlyModule)."/Resources/$studlyResource.php", $template);

        $this->line("Resource $studlyResource has been created!");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['resource', InputArgument::REQUIRED, 'Resource name'],
            ['module', InputArgument::REQUIRED, 'Module name']
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
