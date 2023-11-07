<?php

namespace AdityaDarma\LaravelServiceRepository;

use AdityaDarma\LaravelServiceRepository\Console\RepositoryCommand;
use AdityaDarma\LaravelServiceRepository\Console\ServiceCommand;
use AdityaDarma\LaravelServiceRepository\Console\ServiceRepositoryInstallCommand;
use AdityaDarma\LaravelServiceRepository\Console\NewModelMakeCommand;
use Illuminate\Support\ServiceProvider;

class LaravelServiceRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function boot(): void
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->commands([ServiceCommand::class]);
        $this->commands([RepositoryCommand::class]);
        $this->commands([ServiceRepositoryInstallCommand::class]);
        $this->commands([NewModelMakeCommand::class]);
    }
}
