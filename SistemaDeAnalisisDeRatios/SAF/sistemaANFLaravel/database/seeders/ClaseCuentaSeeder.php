<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClaseCuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clases = [
            [
                "nombre" => "Activos",
            ],
            [
                "nombre" => "Pasivos",
            ],
            [
                "nombre" => "Patrimonio",
            ],
            [
                "nombre" => "Gastos",
            ],
            [
                "nombre" => "Costos",
            ],
            [
                "nombre" => "Ingresos",
            ]
        ];

        foreach ($clases as $clase) {
            DB::table('clase_cuentas')->insert($clase);
        }
    }
}
