<?php

namespace AdityaDarma\LaravelServiceRepository\Console;

use Illuminate\Foundation\Console\ModelMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class ModelCommand extends ModelMakeCommand
{
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        parent::handle();

        // Create repository
        if ($this->option('repository')) {
            $this->call('make:repository', ['name' => $this->getNameInput().'Repository', '--model' => true]);
        }

        // Create traits model
        if ($this->option('trait')) {
            $this->call('make:model-trait', ['name' => $this->getNameInput().'Accessor', 'model' => $this->getNameInput()]);
            $this->call('make:model-trait', ['name' => $this->getNameInput().'Mutator', 'model' => $this->getNameInput()]);
            $this->call('make:model-trait', ['name' => $this->getNameInput().'Relationship', 'model' => $this->getNameInput()]);
            $this->call('make:model-trait', ['name' => $this->getNameInput().'Scope', 'model' => $this->getNameInput()]);
        }
    }

    /**
     * Get option command.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
            ['repository', null, InputOption::VALUE_NONE, 'Create new form repository classes'],
            ['trait', null, InputOption::VALUE_NONE, 'Create with traits classes'],
        ]);
    }

    /**
     * Specify your Stub's location.
     *
     * @return string
     */
    protected function getStub(): string
    {
        if ($this->option('trait')) {
            return __DIR__.'/../Stubs/model-trait.stub';
        }

        return __DIR__.'/../Stubs/model.stub';
    }
}
