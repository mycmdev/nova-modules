<?php


namespace Cmdev\NovaModules\Commands;


use Cmdev\NovaModules\Helpers\ModuleGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakePolicyCommand extends ModuleGeneratorCommand
{
    protected $name = "nova-modules:policy";

    protected $description = "Create new policy";

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
        ], $this->getStub('Policy'));

        $this->createDirIfDoesntExists('Policies', $studlyModule);

        file_put_contents($this->dir($studlyModule)."/Policies/$studlyName.php", $template);

        $this->line("Policy $studlyName has been created!");

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Action name'],
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