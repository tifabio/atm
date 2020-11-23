<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_conta')->insert(
            [
                ['tipo_conta' => 'CONTA_POUPANCA'],
                ['tipo_conta' => 'CONTA_CORRENTE'],
            ]
        );
    }
}
