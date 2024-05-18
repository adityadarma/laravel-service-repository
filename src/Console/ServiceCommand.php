<?php

namespace AdityaDarma\LaravelServiceRepository\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\File;

class ServiceCommand extends GeneratorCommand
{
/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Class type that is being created.
     * If command is executed successfully you'll receive a
     * message like this: $type created succesfully.
     * If the file you are trying to create already
     * exists, you'll receive a message
     * like this: $type already exists!
     */
    protected $type = 'Service';

    /**
     * Specify your Stub's location.
     *
     * @return string
     */
    protected function getStub(): string
    {
        if (File::exists(app_path("Services/BaseService.php"))) {
            return __DIR__.'/../Stubs/service-app.stub';
        } else {
            return __DIR__.'/../Stubs/service.stub';
        }
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
        return $rootNamespace . '\Services';
    }
}
