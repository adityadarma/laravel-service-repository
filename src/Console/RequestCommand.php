<?php

namespace AdityaDarma\LaravelServiceRepository\Console;

use Illuminate\Foundation\Console\RequestMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class RequestCommand extends RequestMakeCommand
{
    /**
     * Get option command.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
            ['single', 's', InputOption::VALUE_NONE, 'Create a single request for many method'],
        ]);
    }

    /**
     * Specify your Stub's location.
     *
     * @return string
     */
    protected function getStub(): string
    {
        if ($this->option('single')) {
            return __DIR__.'/../Stubs/request-single.stub';
        }
        else {
            return __DIR__.'/../Stubs/request.stub';
        }
    }
}
