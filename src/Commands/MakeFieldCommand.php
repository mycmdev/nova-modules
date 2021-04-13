<?php


namespace Cmdev\NovaModules\Commands;


use Cmdev\NovaModules\Helpers\ModuleGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeFieldCommand extends ModuleGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nova-modules:field';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new custom field.';

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
        ], $this->getStub('Field'));

        $this->createDirIfDoesntExists('Fields', $studlyModule);
        $this->createDirIfDoesntExists("Assets/js/Fields/$studlyName", $studlyModule);

        file_put_contents($this->dir($studlyModule)."/Fields/$studlyName.php", $template);

        file_put_contents($this->dir($studlyModule)."/Assets/js/Fields/$studlyName/DetailField.vue", $this->getStub('DetailField'));
        file_put_contents($this->dir($studlyModule)."/Assets/js/Fields/$studlyName/FormField.vue", $this->getStub('FormField'));
        file_put_contents($this->dir($studlyModule)."/Assets/js/Fields/$studlyName/IndexField.vue", $this->getStub('IndexField'));


        $this->line("Field $studlyName has been created!");

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Field name'],
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
