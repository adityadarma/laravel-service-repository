<?php

namespace AdityaDarma\LaravelServiceRepository\Console;

use Illuminate\Foundation\Console\ModelMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class NewModelMakeCommand extends ModelMakeCommand
{
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        parent::handle();

        if ($this->option('repository')) {
            $this->call('make:repository', ['name' => $this->getNameInput().'Repository']);
        }
    }

    protected function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
            ['repository', null, InputOption::VALUE_NONE, 'Create new form repository classes'],
        ]);
    }
}
