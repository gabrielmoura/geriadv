<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_statuses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('client_id')->comment('Cliente');
            $table->foreign('client_id')->references('id')->on('clients');

            $table->unsignedBigInteger('note_id')->nullable()->comment('Observações');
            $table->foreign('note_id')->references('id')->on('notes');

            $table->enum('status', [
                'analysis', //Analise
                'rejected', //Indeferido
                'deferred', //Deferido
                'called_off', //Cancelado
                'cancellation', //Cancelamento
                'deceased' //Falecido
            ])->comment('Status do Cliente')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_statuses');
    }
}
