<?php

namespace App\Console\Commands\X32;

use App\Models\Company;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class X32ForgetSoftDeletes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'x32:forgetDeletes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Forget SoftDeletes';

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
        // Pergunta se tem certeza
        if (!$this->confirm('Are you sure?')) return 0;

        $due_date = config('core.ForgetDeletes');

        $this->info('Forgetting SoftDeletes');

        if ($due_date == 'yearly') {
            $sub_date = now()->subYear();
        } elseif ($due_date == 'monthly') {
            $sub_date = now()->subMonth();
        } elseif ($due_date == 'weekly') {
            $sub_date = now()->subWeek();
        } else {
            $sub_date = now()->subDays(3);
        }

        $this->ForgetCompany($sub_date);

        $this->info('SoftDeletes forgetting completed');


        return 0;
    }

    private function ForgetCompany($sub_date)
    {
        //Busca DeletedAt a $due_date atrás.
        foreach (Company::where('deleted_at', '>=', $sub_date)->get() as $company) {
            Log::info("Company " . $company->name . " Deleted", $company);
            $company->forceDelete();
        }
    }
}
