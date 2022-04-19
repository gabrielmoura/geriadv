<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendencies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('pendency')->comment('Pendencias');
           // $table->unsignedBigInteger('note_id')->nullable()->comment('Observações associadas');
           // $table->foreign('note_id')->references('id')->on('notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendencies');
    }
}
