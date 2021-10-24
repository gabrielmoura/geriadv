<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Provê relacionamento muito para muitos
 * Class CreateClientStatusesClientsTable
 */
class CreateClientStatusesClientsTable extends Migration
{

    public function up()
    {
        Schema::create('client_statuses_clients', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')->onDelete('cascade');

            $table->unsignedBigInteger('status_id');

            $table->foreign('status_id')
                ->references('id')
                ->on('client_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_statuses_clients');
    }
}
