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

            $table->unsignedBigInteger('client_id')->comment('Cliente');
            $table->foreign('client_id')->references('id')->on('clients');

            $table->unsignedBigInteger('user_id')->nullable()->comment('Funcionário');
            $table->foreign('user_id')->references('id')->on('users');
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
