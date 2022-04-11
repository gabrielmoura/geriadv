<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->nullableMorphs('invoiceable');

            $table->unsignedBigInteger('client_id')->nullable()->comment('Client');
            $table->foreign('client_id')->references('id')->on('clients');

            $table->unsignedBigInteger('company_id')->nullable()->comment('Company');
            $table->foreign('company_id')->references('id')->on('companies');

            $table->json('items')->nullable();

            $table->uuid('order_id')->nullable();  //Max:64 caracteres

            $table->integer('user_id')->index()->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
