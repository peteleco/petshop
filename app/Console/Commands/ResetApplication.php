<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the application every night at 00:00.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Put the application in maintenance mode
        $this->info('Entering in maintenance mode');
        $this->call('down');
        $this->info('Refreshing database');
        $this->call('migrate:fresh');
        $this->info('Seeding database');
        $this->call('db:seed');
        $this->info('Exiting maintenance mode');
        $this->call('up');
        $this->info('Done!');
    }
}
