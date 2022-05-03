<?php

use Illuminate\Database\Migrations\Migration;

class CreateClientViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement("
         CREATE VIEW client_views AS

           SELECT clients.id AS client_id,
    clients.cpf,
    clients.last_name,
    clients.name,
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
    benefits.name AS benefit,
    client_statuses.status,
    notes.body AS note,
    recommendations.name AS recommendation,
    clients.tel1,
    clients.slug,
    pendencies.pendency,
    companies.name AS company_name,
    companies.id AS company_id,
    lawyers.id AS lawyer_id,
    lawyers.name AS lawyer_name,
    lawyers.last_name AS lawyer_last_name
   FROM clients
     LEFT JOIN benefits ON benefits.id = clients.benefit_id
     LEFT JOIN client_statuses ON client_statuses.client_id = clients.id AND client_statuses.id = (( SELECT max(client_statuses_1.id) AS max
           FROM client_statuses client_statuses_1
          WHERE client_statuses_1.client_id = clients.id))
     LEFT JOIN pendencies ON clients.pendency_id = pendencies.id
     LEFT JOIN notes ON notes.client_id = clients.id AND notes.id = (( SELECT max(notes_1.id) AS max
           FROM notes notes_1
          WHERE notes_1.client_id = clients.id))
     LEFT JOIN recommendations ON clients.recommendation_id = recommendations.id
     JOIN companies ON benefits.company_id = companies.id AND clients.company_id = companies.id
     LEFT JOIN lawyers ON companies.id = lawyers.company_id AND clients.lawyer_id = lawyers.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS client_views');
    }
}
