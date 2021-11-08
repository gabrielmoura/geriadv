<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            //$table->unsignedBigInteger('user_id');
            //$table->foreign('user_id')->references('id')->on('users');
            $table->string('slug')->index();

            $table->unsignedBigInteger('recommendation_id')->nullable()->comment('Recomendações');
            $table->foreign('recommendation_id')->references('id')->on('recommendations');

            $table->unsignedBigInteger('pendency_id')->nullable()->comment('Pendencias');
            $table->foreign('pendency_id')->references('id')->on('pendencies');


            $table->unsignedBigInteger('benefit_id')->nullable()->comment('Benefícios');
            $table->foreign('benefit_id')->references('id')->on('benefits');

            //$table->unsignedBigInteger('company_id')->nullable()->comment('Empresa');
            //$table->foreign('company_id')->references('id')->on('companies');


            /**
             * Dados Pessoais
             */
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();

            $table->string('cpf');
            $table->string('rg')->nullable();
            $table->string('email')->nullable();
            $table->string('tel0')->comment('telefone')->nullable();
            $table->string('tel1')->nullable();

            $table->enum('sex', ['m', 'f'])->nullable()->comment('Sexo');
            $table->date('birth_date')->comment('Data de nascimento')->nullable();

            /**
             * Dados do Endereço
             */

            $table->integer('cep')->nullable();
            $table->string('address')->comment('Endereço')->nullable();
            $table->integer('number')->comment('Numero');
            $table->string('complement')->nullable()->comment('Complemento');
            $table->string('district')->comment('Bairro');
            $table->string('city')->comment('Cidade');
            $table->string('state')->comment('Estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
