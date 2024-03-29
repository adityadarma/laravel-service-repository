<?php

namespace AdityaDarma\LaravelServiceRepository\Console;

use Illuminate\Console\GeneratorCommand;

class RepositoryCommand extends GeneratorCommand
{
/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name} {--model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * Class type that is being created.
     * If command is executed successfully you'll receive a
     * message like this: $type created succesfully.
     * If the file you are trying to create already
     * exists, you'll receive a message
     * like this: $type already exists!
     */
    protected $type = 'Repository';

    /**
     * Specify your Stub's location.
     *
     * @return string
     */
    protected function getStub(): string
    {
        if ($this->option('model')) {
            return __DIR__.'/../Stubs/repository-model.stub';
        }

        return __DIR__.'/../Stubs/repository.stub';
    }

    /**
     * The root location where your new file should
     * be written to.
     *
     * @param $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Repositories';
    }

    protected function replaceModel($stub, $name): string
    {
        $type = str_replace('Repository', '', $name);

        return str_replace(['{{ model }}', '{{model}}'], $type, $stub);
    }

    protected function buildClass($name): string
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceClass(
            $this->option('model') ? $this->replaceModel($stub, $this->getNameInput()) : $stub,
            $name
        );
    }
}
