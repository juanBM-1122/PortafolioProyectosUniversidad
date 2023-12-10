<?php

namespace Database\Seeders;

use App\Models\CalculoRatio;
use App\Models\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CalculoRatioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empresas = Empresa::all();
        
        $empresas->each(function ($empresa) {
            //Liquidez Corriente
            CalculoRatio::insert([
                "ratio_id" => 1,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getLiquidezCorriente(2021),
                "year" => 2021
            ]);
            CalculoRatio::insert([
                "ratio_id" => 1,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getLiquidezCorriente(2022),
                "year" => 2022
            ]);
            CalculoRatio::insert([
                "ratio_id" => 1,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getLiquidezCorriente(2023),
                "year" => 2023
            ]);
            //Prueba acida
            CalculoRatio::insert([
                "ratio_id" => 2,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getPruebaAcida(2021),
                "year" => 2021
            ]);
            CalculoRatio::insert([
                "ratio_id" => 2,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getPruebaAcida(2022),
                "year" => 2022
            ]);
            CalculoRatio::insert([
                "ratio_id" => 2,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getPruebaAcida(2023),
                "year" => 2023
            ]);
            //Capital de trabajo
            CalculoRatio::insert([
                "ratio_id" => 3,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRazonCapitalTrabajo(2021),
                "year" => 2021
            ]);
            CalculoRatio::insert([
                "ratio_id" => 3,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRazonCapitalTrabajo(2022),
                "year" => 2022
            ]);
            CalculoRatio::insert([
                "ratio_id" => 3,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRazonCapitalTrabajo(2023),
                "year" => 2023
            ]);
            //4
            CalculoRatio::insert([
                "ratio_id" => 4,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRazonEfectivo(2021),
                "year" => 2021
            ]);
            CalculoRatio::insert([
                "ratio_id" => 4,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRazonEfectivo(2022),
                "year" => 2022
            ]);
            CalculoRatio::insert([
                "ratio_id" => 4,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRazonEfectivo(2023),
                "year" => 2023
            ]);
            //5
            CalculoRatio::insert([
                "ratio_id" => 5,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRazonRotacionInventario(2021),
                "year" => 2021
            ]);
            CalculoRatio::insert([
                "ratio_id" => 5,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRazonRotacionInventario(2022),
                "year" => 2022
            ]);
            CalculoRatio::insert([
                "ratio_id" => 5,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRazonRotacionInventario(2023),
                "year" => 2023
            ]);
            //6
            CalculoRatio::insert([
                "ratio_id" => 6,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRazonDiasInventario(2021),
                "year" => 2021
            ]);
            CalculoRatio::insert([
                "ratio_id" => 6,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRazonDiasInventario(2022),
                "year" => 2022
            ]);
            CalculoRatio::insert([
                "ratio_id" => 6,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRazonDiasInventario(2023),
                "year" => 2023
            ]);
            //7
            CalculoRatio::insert([
                "ratio_id" => 7,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRazonRotacionCuentasPorCobrar(2021),
                "year" => 2021
            ]);
            CalculoRatio::insert([
                "ratio_id" => 7,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRazonRotacionCuentasPorCobrar(2022),
                "year" => 2022
            ]);
            CalculoRatio::insert([
                "ratio_id" => 7,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRazonRotacionCuentasPorCobrar(2023),
                "year" => 2023
            ]);
            //8
            CalculoRatio::insert([
                "ratio_id" => 8,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getPeriodoMedioCobranza(2021),
                "year" => 2021
            ]);
            CalculoRatio::insert([
                "ratio_id" => 8,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getPeriodoMedioCobranza(2022),
                "year" => 2022
            ]);
            CalculoRatio::insert([
                "ratio_id" => 8,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getPeriodoMedioCobranza(2023),
                "year" => 2023
            ]);
            //9
            CalculoRatio::insert([
                "ratio_id" => 9,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRotacionCuentasPorPagar(2021),
                "year" => 2021
            ]);
            CalculoRatio::insert([
                "ratio_id" => 9,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRotacionCuentasPorPagar(2022),
                "year" => 2022
            ]);
            CalculoRatio::insert([
                "ratio_id" => 9,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getRotacionCuentasPorPagar(2023),
                "year" => 2023
            ]);
            //10
            CalculoRatio::insert([
                "ratio_id" => 10,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getPeriodoMedioPago(2021),
                "year" => 2021
            ]);
            CalculoRatio::insert([
                "ratio_id" => 10,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getPeriodoMedioPago(2022),
                "year" => 2022
            ]);
            CalculoRatio::insert([
                "ratio_id" => 10,
                "empresa_id" => $empresa->id,
                "valor" => $empresa->getPeriodoMedioPago(2023),
                "year" => 2023
            ]);

        });
    }
}
