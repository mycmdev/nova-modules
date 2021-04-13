<?php


namespace Cmdev\NovaModules\Commands;


use Cmdev\NovaModules\Helpers\ModuleGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeModelCommand extends ModuleGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nova-modules:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model.';

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

        $template = str_replace([
            '{{studlyName}}',
            '{{namespace}}',
        ],[
            $studlyName,
            $namespace,
        ], $this->getStub('Model'));


        $this->createDirIfDoesntExists('Models', $studlyModule);

        file_put_contents($this->dir($studlyModule)."/Models/$studlyName.php", $template);

        $this->line("Model $studlyName has been created!");

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Model name'],
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
