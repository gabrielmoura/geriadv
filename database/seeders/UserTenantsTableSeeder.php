<?php

namespace Database\Seeders;

use App\Models\UserTenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTenantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = DB::getDefaultConnection();

        UserTenant::factory()->create(['email' => "user1@{$company}.com"]);
    }
}
