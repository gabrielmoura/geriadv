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
            $table->string('idEx')->nullable()->comment('ID externo');
            $table->string('name')->comment('Titulo');
            $table->dateTime('start_time')->comment('Inicio');
            $table->dateTime('end_time')->comment('Fim');
            $table->json('properties')->nullable();
            $table->text('description')->comment('Descrição')->nullable();
            $table->enum('recurrence', ['daily', 'weekly', 'monthly', 'none'])->default('none');
            $table->timestamps();

            $table->unsignedBigInteger('company_id')->nullable()->comment('Empresa');
            $table->foreign('company_id')->references('id')->on('companies');

            $table->unsignedInteger('calendar_id')->nullable(); // foreign key to itself
            $table->foreign('calendar_id')->references('id')->on('calendars');

            $table->softDeletes();
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
