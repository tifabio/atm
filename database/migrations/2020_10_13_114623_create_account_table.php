<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_tipo_conta');
            $table->integer('saldo');
            $table->datetime('created_at');
            $table->datetime('updated_at');
            $table->foreign('id_usuario')->references('id')->on('usuario');
            $table->foreign('id_tipo_conta')->references('id')->on('tipo_conta');
            $table->unique(['id_usuario','id_tipo_conta']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conta');
    }
}
