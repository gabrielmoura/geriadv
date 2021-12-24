<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lawyers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable()->comment('Usuário')->index();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('company_id')->comment('Empresa')->index();
            $table->foreign('company_id')->references('id')->on('companies');

            /**
             * Dados Pessoais
             */
            $table->string('name');
            $table->string('last_name')->nullable();

            $table->string('cpf')->nullable();
            $table->integer('oab')->comment('Inscrição OAB')->nullable();
            $table->string('rg')->nullable();
            $table->string('email')->nullable();
            $table->string('tel0')->comment('telefone')->nullable();
            $table->string('tel1')->nullable();

            $table->enum('sex', ['m', 'f'])->nullable()->comment('Sexo');
            $table->date('birth_date')->comment('Data de nascimento')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lawyers');
    }
}
