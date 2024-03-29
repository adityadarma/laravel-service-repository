<?php

namespace AdityaDarma\LaravelServiceRepository;

use AdityaDarma\LaravelServiceRepository\Console\ModelCommand;
use AdityaDarma\LaravelServiceRepository\Console\ModelTraitCommand;
use AdityaDarma\LaravelServiceRepository\Console\RepositoryCommand;
use AdityaDarma\LaravelServiceRepository\Console\RequestCommand;
use AdityaDarma\LaravelServiceRepository\Console\ServiceCommand;
use AdityaDarma\LaravelServiceRepository\Console\ServiceRepositoryInstallCommand;
use Illuminate\Support\ServiceProvider;

class LaravelServiceRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([ServiceRepositoryInstallCommand::class]);

            $this->commands([ServiceCommand::class]);
            $this->commands([RepositoryCommand::class]);
            $this->commands([ModelCommand::class]);
            $this->commands([ModelTraitCommand::class]);
            $this->commands([RequestCommand::class]);
        }
    }
}
