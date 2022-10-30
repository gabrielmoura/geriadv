<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommendationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('company_id')->nullable()->comment('Empresa')->index();
            $table->foreign('company_id')->references('id')->on('companies');

            $table->unsignedBigInteger('user_id')->nullable()->comment('Usuário')->index();
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('name')->comment('Nome')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recommendations');
    }
}
