<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoEstadoFinancieroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table("tipo_estado_financieros")->insert([
            "nombre"=>"Balance General"
        ]);
        \DB::table("tipo_estado_financieros")->insert([
            "nombre"=>"Estado de resultados"
        ]);
    }
}
