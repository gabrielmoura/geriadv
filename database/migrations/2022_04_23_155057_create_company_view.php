<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement("
         CREATE VIEW company_view AS

           SELECT companies.id AS company_id,
    clients.name,
    clients.last_name,
    clients.cpf,
    clients.rg,
    clients.email,
    clients.tel0,
    clients.sex,
    clients.birth_date,
    clients.cep,
    clients.address,
    clients.number,
    clients.complement,
    clients.district,
    clients.city,
    clients.state,
    lawyers.name AS lawyer_name,
    lawyers.last_name AS lawyer_last_name,
    recommendations.name AS recommendation,
    pendencies.pendency,
    benefits.name AS benefit
   FROM companies
     JOIN clients ON companies.id = clients.company_id
     LEFT JOIN lawyers ON companies.id = lawyers.company_id AND clients.lawyer_id = lawyers.id
     LEFT JOIN recommendations ON clients.recommendation_id = recommendations.id
     LEFT JOIN pendencies ON clients.pendency_id = pendencies.id
     JOIN benefits ON companies.id = benefits.company_id AND clients.benefit_id = benefits.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS company_view');
    }
}
