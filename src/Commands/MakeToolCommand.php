<?php


namespace Cmdev\NovaModules\Commands;


use Cmdev\NovaModules\Helpers\ModuleGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeToolCommand extends ModuleGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nova-modules:tool';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new tool connected to your module.';

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

        $moduleUriKey = Str::kebab($this->key('module'));
        $uriKey = Str::kebab($this->key('name'));

        $template = str_replace([
            '{{studlyName}}',
            '{{namespace}}',
            '{{uriKey}}',
            '{{moduleUriKey}}'
        ],[
            $studlyName,
            $namespace,
            $uriKey,
            $moduleUriKey
        ], $this->getStub('Tool'));


        $this->createDirIfDoesntExists('Tools', $studlyModule);
        $this->createDirIfDoesntExists("Assets/js/Tools/$studlyName", $studlyModule);
        $this->createDirIfDoesntExists("Assets/views/$uriKey", $studlyModule);

        file_put_contents($this->dir($studlyModule)."/Tools/$studlyName.php", $template);

        file_put_contents($this->dir($studlyModule)."/Assets/js/Tools/$studlyName/Tool.vue", $this->getStub('ToolVue'));

        file_put_contents($this->dir($studlyModule)."/Assets/views/$uriKey/navigation.blade.php", $this->getStub('ToolNavigation'));

        $this->line("Your tool $studlyName has been created!");

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Custom tool name'],
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
