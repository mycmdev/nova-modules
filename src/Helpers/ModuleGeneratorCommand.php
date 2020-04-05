<?php


namespace Cmdev\NovaModules\Helpers;


use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

abstract class ModuleGeneratorCommand extends Command
{
    protected function getStub($stub)
    {
        $stub = ucwords($stub);
        return file_get_contents( __DIR__ . "/../Stubs/$stub.stub");
    }

    protected function dir($module = null)
    {
        return $module ? config('nova-modules.path')."/".$module : config('nova-modules.path');
    }

    protected function namespace()
    {
        $namespace = config('nova-modules.namespace');

        $studlyModule = Str::studly($this->argument('module'));

        return "$namespace\\$studlyModule";
    }

    protected function key($argument)
    {
        return preg_replace('/[^a-zA-Z0-9]+/', '', $this->argument($argument));
    }



}
