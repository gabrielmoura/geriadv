<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->unsignedBigInteger('user_id')->nullable()->comment('Usuário')->index();
            $table->foreign('user_id')->references('id')->on('users');

            //$table->unsignedBigInteger('company_id')->comment('Empresa')->index();
            //$table->foreign('company_id')->references('id')->on('companies');

             /**
             * Dados Pessoais
             */
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();

            $table->string('cpf')->nullable();
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
            $table->integer('number')->comment('Numero')->nullable();
            $table->string('complement')->nullable()->comment('Complemento');
            $table->string('district')->comment('Bairro')->nullable();
            $table->string('city')->comment('Cidade')->nullable();
            $table->string('state')->comment('Estado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
