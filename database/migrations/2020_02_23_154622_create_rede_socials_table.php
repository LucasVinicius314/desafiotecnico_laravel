<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedeSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rede_socials', function (Blueprint $table) {
            $table->bigIncrements('_id');
            $table->string('nome');
            $table->string('url');
            $table->integer('deputados_id');
            $table->foreign('deputados_id')->references('id')->on('deputados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rede_socials');
    }
}
