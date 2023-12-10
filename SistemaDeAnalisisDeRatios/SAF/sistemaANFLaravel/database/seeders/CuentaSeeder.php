<?php

namespace Database\Seeders;

use App\Models\SubCuenta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    const ACTIVOS_CORRIENTES = "Activos corrientes";
    const ACTIVOS_NO_CORRIENTES = "Activos no corrientes";

    const PASIVOS_CORRIENTES = "Pasivos corrientes";

    const PASIVOS_NO_CORRIENTES = "Pasivos no corrientes";
    const CAPITAL_CONTABLE = "Capital contable";

    const GASTOS_DE_OPERACION = "Gastos de operacion";
    const COSTOS_DE_OPERACION = "Costos de operacion";
    const INGRESOS_DE_OPERACION = "Ingresos de operacion";
    const UTILIDADES_CALCULADAS = "Utilidades calculadas";

    public function run()
    {
        $activosCorrientes = SubCuenta::where("nombre", self::ACTIVOS_CORRIENTES)->first();
        $activosNoCorrientes = SubCuenta::where("nombre", self::ACTIVOS_NO_CORRIENTES)->first();
        $pasivosCorrientes = SubCuenta::where("nombre", self::PASIVOS_CORRIENTES)->first();
        $pasivosNoCorrientes = SubCuenta::where("nombre", self::PASIVOS_NO_CORRIENTES)->first();
        $capitalContable = SubCuenta::where("nombre", self::CAPITAL_CONTABLE)->first();
        $gastosDeOperacion = SubCuenta::where("nombre",self::GASTOS_DE_OPERACION)->first();
        $costosDeOperacion = SubCuenta::where("nombre",self::COSTOS_DE_OPERACION)->first();
        $ingresosDeOperacion = SubCuenta::where("nombre",self::INGRESOS_DE_OPERACION)->first();
        $utilidadesCalculadas = SubCuenta::where("nombre",self::UTILIDADES_CALCULADAS)->first();

        if (isset($activosCorrientes,$activosNoCorrientes)) {
           $cuentas = [
                /*cuentasActivosCorrientes*/
                    [
                        "sub_cuenta_id" => $activosCorrientes->id,
                        "nombre" => "Efectivo y equivalentes"
                    ],
                    [
                        "sub_cuenta_id" => $activosCorrientes->id,
                        "nombre" => "Cuentas por cobrar"
                    ],
                    [
                        "sub_cuenta_id" => $activosCorrientes->id,
                        "nombre" => "Inventario"
                    ],
                    [
                        "sub_cuenta_id"=> $activosCorrientes->id,
                        "nombre"=>"Gastos pagados por anticipado"
                    ],
                    [
                        "sub_cuenta_id"=> $activosCorrientes->id,
                        "nombre"=>"Otros Activos Corrientes"
                    ],
                /*cuentasActivosNoCorrientes*/
                    [
                        "sub_cuenta_id" => $activosNoCorrientes->id,
                        "nombre" => "Propiedad, planta y equipo"
                    ],
                    [
                        "sub_cuenta_id" => $activosNoCorrientes->id,
                        "nombre" => "Depreciación y amortización",
                    ],
                    [
                        "sub_cuenta_id" => $activosNoCorrientes->id,
                        "nombre" => "otros activos",
                    ],
                    [
                        "sub_cuenta_id" => $activosNoCorrientes->id,
                        "nombre" => "Otros Activos No Corrientes",
                    ],
                /*cuentasPasivosCorrientes*/
                    [
                        "sub_cuenta_id" => $pasivosCorrientes->id,
                        "nombre" => "Cuentas por pagar"
                    ],
                    [
                        "sub_cuenta_id" => $pasivosCorrientes->id,
                        "nombre" => "Documentos por pagar"
                    ],
                    [
                        "sub_cuenta_id" => $pasivosCorrientes->id,
                        "nombre" => "Deudas acumuladas"
                    ],
                    [
                        "sub_cuenta_id" => $pasivosCorrientes->id,
                        "nombre" => "Otros Pasivos Corrientes"
                    ],
                    [
                        "sub_cuenta_id" => $pasivosCorrientes->id,
                        "nombre" => "Deudas o cuentas acumuladas"
                    ],
                /*cuentasPasivosNoCorrientes*/
                    [
                        "sub_cuenta_id" => $pasivosNoCorrientes->id,
                        "nombre" => "Prestamos a largo plazo"
                    ],
                    [
                        "sub_cuenta_id" => $pasivosNoCorrientes->id,
                        "nombre" => "Otros Pasivos No Corrientes"
                    ],
                /*cuentasCapital*/
                    [
                        "sub_cuenta_id" => $capitalContable->id,
                        "nombre" => "Capital social"
                    ],
                    [
                        "sub_cuenta_id" => $capitalContable->id,
                        "nombre" => "Utilidades por distribuir"
                    ],
                    [
                        "sub_cuenta_id" => $capitalContable->id,
                        "nombre" => "Otros Valores de Capital"
                    ],
                /*Cuentas de gastos de operacion */
                  [
                    "sub_cuenta_id"=> $gastosDeOperacion->id,
                    "nombre"=>"Gastos de venta"
                  ],
                  [
                    "sub_cuenta_id"=> $gastosDeOperacion->id,
                    "nombre"=>"Gastos generales y administrativos"
                  ],
                  [
                    "sub_cuenta_id"=> $gastosDeOperacion->id,
                    "nombre"=>"Gastos de arrendamiento"
                  ],
                  [
                    "sub_cuenta_id"=> $gastosDeOperacion->id,
                    "nombre"=>"Gastos de depreciación"
                  ],
                  [
                    "sub_cuenta_id"=> $gastosDeOperacion->id,
                    "nombre"=>"Otros Gastos de Operación"
                  ],
                /*Cuentas de costos de operacion */
                [
                    "sub_cuenta_id"=> $costosDeOperacion->id,
                    "nombre"=>"Costo de los bienes vendidos"
                ],
                [
                    "sub_cuenta_id"=> $costosDeOperacion->id,
                    "nombre"=>"Otros Costos De Operación"
                ],
                /*Cuentas de ingresos de operacion */
                [
                    "sub_cuenta_id"=> $ingresosDeOperacion->id,
                    "nombre"=>"Ingresos por ventas"
                ],
                [
                    "sub_cuenta_id"=> $ingresosDeOperacion->id,
                    "nombre"=>"Otros Ingresos de Operacion"
                ],
                [
                    "sub_cuenta_id"=> $ingresosDeOperacion->id,
                    "nombre"=>"Descuentos y devoluciones"
                ],
                /* Cuentas de utilidades calculadas */
                [
                    "sub_cuenta_id"=> $utilidadesCalculadas->id,
                    "nombre"=>"Utilidad bruta"
                ],
                [
                    "sub_cuenta_id"=> $utilidadesCalculadas->id,
                    "nombre"=>"Utilidad neta antes de impuesto"
                ],
                [
                    "sub_cuenta_id"=> $utilidadesCalculadas->id,
                    "nombre"=>"Utilidad neta despues de impuesto"
                ],
                [
                    "sub_cuenta_id"=> $utilidadesCalculadas->id,
                    "nombre"=>"Utilidad operativa"
                ],
            ];

            foreach($cuentas as $cuenta) {
                \DB::table("cuentas")->insert($cuenta);
            }


        }





    }
}
