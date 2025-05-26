<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Contract extends Command
{
   /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:contract {name : The name of the interface}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new interface class';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $name = $this->argument('name');
        $serviceClass = $name . 'Interface';

        $path = app_path('Contracts') . '/' . $serviceClass . '.php';

        if (File::exists($path)) {
            $this->error('Contract class already exists!');
            return;
        }

        if(!is_dir(app_path('Contracts') . '/')) {
            File::makeDirectory(app_path('Contracts'));
        }

        $stub = str_replace(
            'NewInterface',
            $serviceClass,
            File::get(__DIR__ . '/stubs/contract.stub')
        );

        File::put($path, $stub);

        $this->info("$name Contract created successfully!");
    }
}
