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
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create n new repository class';

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
     */
    protected function getStub()
    {
        return __DIR__.'/../Stubs/repository.stub';
    }

    /**
     * The root location where your new file should
     * be written to.
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repositories';
    }
}