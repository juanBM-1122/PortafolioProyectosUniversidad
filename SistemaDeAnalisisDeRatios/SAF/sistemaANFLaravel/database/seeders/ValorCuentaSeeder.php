<?php

namespace Database\Seeders;

use App\Models\CuentaEmpresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ValorCuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cuentasEmpresa1 = CuentaEmpresa::where("empresa_id",1)->get();
        $cuentasEmpresa2 = CuentaEmpresa::where("empresa_id",2)->get();

        $valoresEmpresa1 = [];
        $valoresEmpresa2 = [];
        
        foreach ($cuentasEmpresa1 as $cuenta) {
            $valorCuenta = [
                "cuenta_empresa_id"=> $cuenta->id,
                "valorCuenta" => (float)rand(1000,10000),
                "year"=>2021
            ];
            array_push($valoresEmpresa1, $valorCuenta);

            $valorCuenta = [
                "cuenta_empresa_id"=> $cuenta->id,
                "valorCuenta" => (float)rand(1000,10000),
                "year"=>2022
            ];
            array_push($valoresEmpresa1, $valorCuenta);

            $valorCuenta = [
                "cuenta_empresa_id"=> $cuenta->id,
                "valorCuenta" => (float)rand(1000,10000),
                "year"=>2023
            ];
            array_push($valoresEmpresa1, $valorCuenta);
        }

        foreach ($cuentasEmpresa2 as $cuenta) {
            $valorCuenta = [
                "cuenta_empresa_id"=> $cuenta->id,
                "valorCuenta" => (float)rand(1000,10000),
                "year"=>2021
            ];
            array_push($valoresEmpresa2, $valorCuenta);

            $valorCuenta = [
                "cuenta_empresa_id"=> $cuenta->id,
                "valorCuenta" => (float)rand(1000,10000),
                "year"=>2022
            ];
            array_push($valoresEmpresa2, $valorCuenta);

            $valorCuenta = [
                "cuenta_empresa_id"=> $cuenta->id,
                "valorCuenta" => (float)rand(1000,10000),
                "year"=>2023
            ];
            array_push($valoresEmpresa2, $valorCuenta);
        }
        

        foreach($valoresEmpresa1 as $valoresEmpresa) {
            \DB::table("valor_cuentas")->insert($valoresEmpresa);
        }

        foreach($valoresEmpresa2 as $valoresEmpresa) {
            \DB::table("valor_cuentas")->insert($valoresEmpresa);
        }

    }
}
