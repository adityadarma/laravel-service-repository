<?php

namespace AdityaDarma\LaravelServiceRepository\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class ModelTraitCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:model-trait {name} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model trait';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model Trait';

    /**
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__.'/../Stubs/trait-model.stub';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the model to which the model will be generated'],
        ];
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Models\Traits\\'.$this->argument('model');
    }
}
