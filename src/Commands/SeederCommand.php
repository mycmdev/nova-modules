<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25/06/2020
 * Time: 11:55
 */

namespace Cmdev\NovaModules\Commands;

use Cmdev\NovaModules\Helpers\ModuleGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SeederCommand extends ModuleGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nova-modules:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run module seeder';

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
        $ucName = Str::studly($module);

        $seeder = "{$this->namespace()}\\Database\\Seeders\\{$ucName}DatabaseSeeder";

        if(class_exists($seeder)){
            $this->call('db:seed', ['--class' => $seeder]);
            $this->info("{$ucName} : Seeding done");
        }else{
            $this->info("Error during seeding. Class {$seeder} doesn't exists.", "warning");
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
            ['module', InputArgument::REQUIRED, "Module's name"],
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
