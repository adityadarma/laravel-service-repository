<?php

namespace AdityaDarma\LaravelServiceRepository\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ServiceRepositoryInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service-repository:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will copy base service file and trait file to your project.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        // Service
        if (File::exists(app_path("Services/BaseService.php"))) {
            $confirm = $this->confirm("BaseService.php file already exist. Do you want to overwrite?");
            if ($confirm) {
                $this->publishService();
                $this->info("base service overwrite finished");
            } else {
                $this->info("skipped base service publish");
            }
        } else {
            $this->publishService();
            $this->info("base service published");
        }


        // Trait
        if (File::exists(app_path("Traits/JsonValidateResponse.php"))) {
            $confirm = $this->confirm("Traits JsonValidateResponse.php file already exist. Do you want to overwrite?");
            if ($confirm) {
                $this->publishTrait();
                $this->info("traits overwrite finished");
            } else {
                $this->info("skipped traits publish");
            }
        } else {
            $this->publishTrait();
            $this->info("traits published");
        }
    }

    /**
     * Publish base service
     *
     * @return void
     */
    private function publishService(): void
    {
        if(!File::isDirectory(app_path("Services"))){
            File::makeDirectory(app_path("Services"));
        }
        File::copy(__DIR__ . "/../Services/BaseService.php", app_path("Services/BaseService.php"));
    }

    /**
     * Publish trait validate request
     *
     * @return void
     */
    private function publishTrait(): void
    {
        if(!File::isDirectory(app_path("Traits"))){
            File::makeDirectory(app_path("Traits"));
        }
        File::copy(__DIR__ . "/../Traits/JsonValidateResponse.php", app_path("Traits/JsonValidateResponse.php"));
    }
}
