<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_conta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_conta');
        });

        DB::table('tipo_conta')->insert(
            [
                ['tipo_conta' => 'CONTA_POUPANCA'],
                ['tipo_conta' => 'CONTA_CORRENTE'],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_conta');
    }
}
