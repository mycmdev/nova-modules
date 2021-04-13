<?php


namespace Cmdev\NovaModules\Commands;


use Cmdev\NovaModules\Helpers\ModuleGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeModuleCommand extends ModuleGeneratorCommand
{
    /**
     * Module StudlyName
     * @var
     */
    protected $studlyName;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nova-modules:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module.';

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
        $name = $this->argument('module');

        $this->studlyName = Str::studly($name);

        $this->generateModuleDirectories();

        $this->generateProvider();

        $this->generateApiRoutes();

        $this->generateComposer();

        $this->generateMix();

        $this->generateAssets();

        $this->generateGit();
    }


    protected function generateModuleDirectories()
    {

        if(!is_dir($this->dir())){
            mkdir($this->dir());
        }

        mkdir($this->dir($this->studlyName));

        $directories = [
            'Assets',
            'Database',
            'Providers',
            'Routes',
            'Assets/js',
            'Assets/js/Fields',
            'Assets/js/Filters',
            'Assets/js/Cards',
            'Assets/js/ResourceTools',
            'Assets/js/Tools',
            'Assets/sass',
            'Assets/views',
            'Database/migrations',
            'Database/seeds',
        ];

        foreach ($directories as $directory){
            $this->createDirIfDoesntExists($directory, $this->studlyName);
        }

        $this->line('Directories have been created');
    }

    protected function generateProvider()
    {
        $uriKey = Str::kebab($this->key('module'));

        $template = str_replace([
            '{{studlyName}}',
            '{{namespace}}',
            '{{uriKey}}'
        ],[
            $this->studlyName,
            $this->namespace(),
            $uriKey
        ], $this->getStub('ServiceProvider'));

        file_put_contents($this->dir($this->studlyName)."/Providers/{$this->studlyName}ServiceProvider.php", $template);

        $this->line("ServiceProvider has been created!");
    }

    protected function generateApiRoutes()
    {

        $uriKey = Str::kebab($this->key('module'));

        $template = str_replace([
            '{{uriKey}}'
        ],[
            $uriKey
        ], $this->getStub('Api'));

        file_put_contents($this->dir($this->studlyName)."/Routes/api.php", $template);

        $this->line("Route has been created!");
    }

    protected function generateComposer()
    {
        $namespace = config('nova-modules.namespace');
        $template = str_replace([
            '{{serviceProvider}}'
        ],[
            "$namespace\\\\$this->studlyName\\\\Providers\\\\".$this->studlyName."ServiceProvider"
        ], $this->getStub('Composer'));

        file_put_contents($this->dir($this->studlyName)."/composer.json", $template);

        $this->line("Composer has been created!");
    }

    protected function generateMix()
    {
        $uriKey = Str::kebab($this->key('module'));

        $template = str_replace([
            '{{uriKey}}'
        ],[
            $uriKey
        ], $this->getStub('Mix'));

        file_put_contents($this->dir($this->studlyName)."/webpack.mix.js", $template);
        file_put_contents($this->dir($this->studlyName)."/package.json", $this->getStub('Package'));

        $this->line("Webpack and Package have been created!");
    }

    protected function generateAssets()
    {
        $uriKey = Str::kebab($this->key('module'));

        file_put_contents($this->dir($this->studlyName)."/Assets/js/$uriKey.js", $this->getStub('Js'));
        file_put_contents($this->dir($this->studlyName)."/Assets/sass/$uriKey.scss", $this->getStub('Css'));

        $this->line("Assets have been created!");
    }

    protected function generateGit()
    {
        file_put_contents($this->dir($this->studlyName)."/.gitignore", $this->getStub('Git'));

        //Nothing special, no need to let user know about creating a stupid .gitignore :)
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
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
