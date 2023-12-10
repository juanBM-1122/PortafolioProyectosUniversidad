<?php

namespace Database\Seeders;

use App\Models\Ratio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ratios = [
            [
                "nombre" => "Liquidez Corriente"
            ],
            [
                "nombre" => "Prueba Acida"
            ],
            [
                "nombre" => "Razon de Capital de trabajo"
            ],
            [
                "nombre" => "Razon de efectivo"
            ],
            [
                "nombre" => "Razon de rotación de Inventario"
            ],
            [
                "nombre" => "Razón de días de inventario"
            ],
            [
                "nombre" => "Razon de rotación de cuentas por cobrar"
            ],
            [
                "nombre" => "Razón de periodo medio de cobranza"
            ],
            [
                "nombre" => "Razón de rotación de cuentas por pagar"
            ],
            [
                "nombre" => "Razón de periodo medio de pago"
            ],
        ];

        foreach ($ratios as $ratio) {
            Ratio::create($ratio);
        }
    }
}
