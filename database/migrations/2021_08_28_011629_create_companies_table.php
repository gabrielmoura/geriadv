<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->ulid('pid')->comment('Public ID');
            $table->timestamps();
            $table->softDeletes();

            /**
             * Dados Pessoais
             */

            $table->string('email')->nullable();
            $table->string('tel0')->comment('telefone')->nullable();
            $table->string('name')->nullable();
            $table->string('cnpj')->nullable();

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

            /**
             * Configurações
             */
            $table->json('config')->comment('Configuração')->default('{}');
            $table->string('logo')->nullable();
            $table->boolean('banned')->comment('Banido')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
