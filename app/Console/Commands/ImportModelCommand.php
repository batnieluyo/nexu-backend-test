<?php

namespace App\Console\Commands;

use App\Actions\ImportModelsAction;
use Illuminate\Console\Command;

class ImportModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the models from json file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Importing models...');
        (new ImportModelsAction)->handle();
        $this->info('Importing models finished');
    }
}
