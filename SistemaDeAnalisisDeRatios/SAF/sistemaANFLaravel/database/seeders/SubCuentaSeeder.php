<?php

namespace Database\Seeders;

use App\Models\ClaseCuenta;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $activos = ClaseCuenta::where("nombre","Activos")->first();
        if (isset($activos)) {
            DB::table("sub_cuentas")->insert([
                "clase_cuenta_id"=>$activos->id,
                "nombre"=> "Activos corrientes",
            ]);
            DB::table("sub_cuentas")->insert([
                "clase_cuenta_id"=>$activos->id,
                "nombre"=> "Activos no corrientes",
            ]);
        }

        $pasivos = ClaseCuenta::where("nombre","Pasivos")->first();
        if (isset($pasivos)) {
            DB::table("sub_cuentas")->insert([
                "clase_cuenta_id"=>$pasivos->id,
                "nombre"=> "Pasivos corrientes",
            ]);
            DB::table("sub_cuentas")->insert([
                "clase_cuenta_id"=>$pasivos->id,
                "nombre"=> "Pasivos no corrientes",
            ]);
        }
        $patrimonio = ClaseCuenta::where("nombre","Patrimonio")->first();
        if (isset($patrimonio)) {
            DB::table("sub_cuentas")->insert([
                "clase_cuenta_id"=>$patrimonio->id,
                "nombre"=> "Capital contable",
            ]);

        $gastos = ClaseCuenta::where("nombre","Gastos")->first();
        if(isset($gastos)){
            DB::table("sub_cuentas")->insert([
                "clase_cuenta_id"=>$gastos->id,
                "nombre"=>"Gastos de operacion",
            ]);
        }
        $costos = ClaseCuenta::where("nombre","Costos")->first();

        if(isset($costos)){
            DB::table("sub_cuentas")->insert([
                "clase_cuenta_id"=>$costos->id,
                "nombre"=>"Costos de operacion"
            ]);
        }

        $ingresos = ClaseCuenta::where("nombre","Ingresos")->first();
        if(isset($ingresos)){
            DB::table("sub_cuentas")->insert([
                "clase_cuenta_id"=>$ingresos->id,
                "nombre"=>"Ingresos de operacion"
            ]);
            DB::table("sub_cuentas")->insert([
                "clase_cuenta_id"=>$ingresos->id,
                "nombre"=>"Utilidades calculadas"
            ]);
        }
    }
  }
}
