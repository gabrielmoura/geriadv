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
            $table->timestamps();

            $table->string('name')->index();
            $table->tinyText('description')->nullable();
<<<<<<< HEAD

            $table->unsignedBigInteger('client_id')->comment('Cliente');
            $table->foreign('client_id')->references('id')->on('clients');

            $table->unsignedBigInteger('user_id')->nullable()->comment('Funcionário');
            $table->foreign('user_id')->references('id')->on('users');
=======
            $table->decimal('wage')->comment('Remuneração');

            $table->unsignedBigInteger('company_id')->nullable()->comment('Empresa');
            $table->foreign('company_id')->references('id')->on('companies');

             /**
             * Regras de Negocio
             */
            //Usado para calcular valores a receber.
            $table->float('wage_factor')->comment('Fator de Remuneração')->nullable();
            //Usado para escolher o calculo aplicado.
            $table->enum('wage_type',['percent','salary'])->comment('Tipo de Remuneração')->nullable();
>>>>>>> origin/FeitoNoTrabalho
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
