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

            $table->boolean('cras')->comment('CRAS')->nullable();
            $table->boolean('cpf')->comment('CPF')->nullable();
            $table->boolean('rg')->comment('RG')->nullable();
            $table->boolean('birth_certificate')->comment('Certidão de Nascimento')->nullable();
            $table->boolean('proof_of_address')->comment('Comprovante de Residencia')->nullable();
            $table->boolean('impossibility_to_sign')->comment('Impossibilitado de assinar')->nullable();

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
