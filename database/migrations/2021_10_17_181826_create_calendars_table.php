<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('idEx')->nullable()->comment('ID externo');
            $table->string('name')->comment('Titulo');
            $table->dateTime('start_time')->comment('Inicio');
            $table->dateTime('end_time')->comment('Fim');
            $table->string('address')->nullable()->comment('Address');


            $table->enum('recurrence', ['daily', 'weekly', 'monthly', 'none'])->default('none');


            $table->unsignedBigInteger('company_id')->nullable()->comment('Empresa');
            $table->foreign('company_id')->references('id')->on('companies');

            $table->unsignedBigInteger('lawyer_id')->nullable()->comment('Advogado');
            $table->foreign('lawyer_id')->references('id')->on('lawyers');

            $table->unsignedInteger('calendar_id')->nullable(); // foreign key to itself
            $table->foreign('calendar_id','calendar_fk_556522')->references('id')->on('calendars');

            $table->json('properties')->nullable();
            $table->text('description')->comment('Descrição')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendars');
    }
}
