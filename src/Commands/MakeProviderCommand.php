<?php


namespace Cmdev\NovaModules\Commands;


use Cmdev\NovaModules\Helpers\ModuleGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeProviderCommand extends ModuleGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nova-modules:provider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service provider.';

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

        $sanitizedName = str_replace(['Service', 'Provider'], ['', ''], $studlyName);

        if($sanitizedName == $studlyModule){
            $this->warn('Warning! You are going to ovveride main module service provider!');
            $this->warn('Action aborted!');
            $this->line("If you want to ovveride it, please do it manually, only if you know what you're going to do..");
        }else{
            $template = str_replace([
                '{{studlyName}}',
                '{{namespace}}',
            ],[
                $sanitizedName,
                $namespace,
            ], $this->getStub('CustomProvider'));

            $this->createDirIfDoesntExists('Providers', $studlyModule);

            file_put_contents($this->dir($studlyModule)."/Providers/{$sanitizedName}ServiceProvider.php", $template);

            $this->line("{$sanitizedName}ServiceProvider has been created! Don't forget to register it!");
        }



    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Service provider name'],
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
