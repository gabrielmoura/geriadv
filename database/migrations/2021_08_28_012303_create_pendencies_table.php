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

            $table->binary('cras')->comment('CRAS');
            $table->binary('cpf')->comment('CPF');
            $table->binary('rg')->comment('RG');
            $table->binary('birth_certificate')->comment('Certidão de Nascimento');
            $table->binary('proof_of_address')->comment('Comprovante de Residencia');
            $table->binary('impossibility_to_sign')->comment('Impossibilitado de assinar');

            $table->unsignedBigInteger('note_id')->nullable()->comment('Observações associadas');
            $table->foreign('note_id')->references('id')->on('notes');

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
