<?php

namespace Database\Seeders;

use App\Models\Benefits;
use App\Models\Clients;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Lawyer;
use Illuminate\Database\Seeder;

class PopulateCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::factory(10)->create();
        Benefits::factory(3)->create();
        Employee::factory(10)->create();
        //Lawyer::factory(10)->create();
        Clients::factory(1000)->create();
    }
}
