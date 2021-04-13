<?php


namespace Cmdev\NovaModules\Commands;


use Cmdev\NovaModules\Helpers\ModuleGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeResourceToolCommand extends ModuleGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nova-modules:resource-tool';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new resource tool.';

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
        $name = $this->argument('name');

        $module = $this->argument('module');

        $studlyName = Str::studly($name);

        $namespace = $this->namespace();

        $studlyModule = Str::studly($module);

        $uriKey = Str::kebab($this->key('name'));

        $template = str_replace([
            '{{studlyName}}',
            '{{namespace}}',
            '{{uriKey}}'
        ],[
            $studlyName,
            $namespace,
            $uriKey
        ], $this->getStub('ResourceTool'));

        $this->createDirIfDoesntExists('ResourceTools', $studlyModule);
        $this->createDirIfDoesntExists("/Assets/js/ResourceTools/$studlyName", $studlyModule);

        file_put_contents($this->dir($studlyModule)."/ResourceTools/$studlyName.php", $template);

        file_put_contents($this->dir($studlyModule)."/Assets/js/ResourceTools/$studlyName/Tool.vue", $this->getStub('ResourceToolVue'));

        $this->line("Resource tool $studlyName has been created!");

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Resource tool name'],
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
