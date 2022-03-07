<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{

    /**
     * @return void
     */
    public function up()
    {
        Schema::create('billets', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->index()->unsigned()->nullable();

            $table->string('transaction_id');
            $table->uuid('order_id');  //Max:64 caracteres
            $table->string('status')->default('pending'); //Max:16 caracteres
            $table->json('quantity')->nullable();
            $table->json('items')->nullable();
            $table->integer('value_cents')->comment('Valor em centavos');
            $table->string('notification_id')->nullable();
            $table->json('bank_slip')->nullable();
            $table->timestamp('due_date')->nullable()->comment('Dia do Vencimento');

            $table->unsignedBigInteger('client_id')->nullable()->comment('Client');
            $table->foreign('client_id')->references('id')->on('clients');

            $table->unsignedBigInteger('company_id')->nullable()->comment('Company');
            $table->foreign('company_id')->references('id')->on('companies');

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::drop('billets');
    }
}
