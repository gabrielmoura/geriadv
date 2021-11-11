<?php

namespace App\Console\Commands\X32;

use Illuminate\Console\Command;

class X32Populate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'x32:populate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create dummy users and clients for testing.';

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
     * @return int
     */
    public function handle()
    {
        $this->info('Seeding system');

        $this->call('db:seed', [
            '--class' => 'PopulateCompanySeeder'
        ]);

        $this->info('Seeding system finished');
    }
}
