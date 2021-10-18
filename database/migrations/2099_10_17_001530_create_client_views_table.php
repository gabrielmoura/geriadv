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

         SELECT clients.id,
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
    pendencies.cras AS pendency_cras,
    pendencies.cpf AS pendency_cpf,
    pendencies.rg AS pendency_rg,
    pendencies.birth_certificate AS pendency_birth_certificate,
    pendencies.proof_of_address AS pendency_proof_of_address,
    pendencies.impossibility_to_sign AS pendency_impossibility_to_sign,
    notes.body AS note,
    recommendations.name AS recommendation,
    clients.tel1,
    clients.slug
   FROM (((((clients
     JOIN benefits ON ((benefits.client_id = clients.id)))
     JOIN client_statuses ON (((client_statuses.client_id = clients.id) AND (client_statuses.id = ( SELECT max(client_statuses_1.id) AS max
           FROM client_statuses client_statuses_1
          WHERE (client_statuses_1.client_id = clients.id))))))
     LEFT JOIN pendencies ON ((clients.pendency_id = pendencies.id)))
     LEFT JOIN notes ON (((notes.client_id = clients.id) AND (notes.id = ( SELECT max(notes_1.id) AS max
           FROM notes notes_1
          WHERE (notes_1.client_id = clients.id))))))
     JOIN recommendations ON ((clients.recommendation_id = recommendations.id)))
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
