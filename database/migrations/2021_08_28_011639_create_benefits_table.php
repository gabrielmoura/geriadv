<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benefits', function (Blueprint $table) {
            $table->id();
            $table->ulid('pid')->index();
            $table->timestamps();

            $table->string('name')->index();
            $table->tinyText('description')->nullable();

            $table->decimal('wage')->comment('Remuneração')->nullable();

            $table->unsignedBigInteger('company_id')->nullable()->comment('Empresa');
            $table->foreign('company_id')->references('id')->on('companies');

             /**
             * Regras de Negocio
             */
            //Usado para calcular valores a receber.
            $table->float('wage_factor')->comment('Fator de Remuneração')->nullable();
            //Usado para escolher o calculo aplicado.
            $table->enum('wage_type',['percent','salary'])->comment('Tipo de Remuneração')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('benefits');
    }
}
