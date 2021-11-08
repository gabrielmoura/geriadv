<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_socials', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('user_id')->nullable()->comment('Usuário')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('drive');

            // OAuth 2.0 providers...
            $table->string('token');
            $table->string('refreshToken')->nullable();
            $table->string('expiresIn')->nullable();

            // OAuth 1.0 providers...

            $table->string('tokenSecret')->nullable();

            // All providers...
            $table->integer('socialId');
            $table->string('nickname');
            $table->string('name');
            $table->string('email');
            $table->string('avatar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_socials');
    }
}
