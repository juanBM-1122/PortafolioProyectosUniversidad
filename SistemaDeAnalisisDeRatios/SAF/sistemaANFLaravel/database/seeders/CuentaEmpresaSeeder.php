<?php

namespace Database\Seeders;

use App\Models\CuentaEmpresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CuentaEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $cuentas = [
            [
                'empresa_id'=>1,
                'cuenta_id'=>1,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Caja",

            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>2,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Clientes"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>2,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Otras cuentas por cobrar"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>1,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Bancos"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>3,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Inventarios"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>4,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Gastos por anticipado"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>5,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Otros activos corrientes"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>6,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Maquinaria"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>7,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Depreciacion"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>8,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Otros activos"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>9,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Otros activos no corrientes"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>10,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Cuentas por pagar"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>11,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Documentos por pagar"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>12,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Deudas acumuladas"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>13,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Otros pasivos corrientes"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>14,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Deudas acumuladas"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>15,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Prestamos a largo plazo 1"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>15,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Prestamos a largo plazo 2"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>16,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Otros pasivos no corrientes"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>17,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Capital social"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>18,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Utilidades por distribuir"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>19,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Otros valores de capital"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>20,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Gastos de ventas"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>21,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Gastos generales y administrativos"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>22,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Gastos de arrendamiento"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>23,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Gastos de depreciación"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>24,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Otros gastos de operación"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>25,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Costo de los bienes vendidos"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>26,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Otros costos de operacion"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>27,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Ingresos por ventas"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>28,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Otros ingresos de operación"
            ],
            [
                'empresa_id'=>1,
                'cuenta_id'=>29,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Descuentos y devoluciones"
            ],


            //Para empresa 2
            [
                'empresa_id'=>2,
                'cuenta_id'=>1,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Caja e2",

            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>2,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Clientes e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>2,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Otras cuentas por cobrar e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>1,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Bancos e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>3,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Inventarios e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>4,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Gastos por anticipado e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>5,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Otros activos corrientes e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>6,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Maquinaria e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>7,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Depreciacion e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>8,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Otros activos e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>9,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Otros activos no corrientes e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>10,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Cuentas por pagar e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>11,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Documentos por pagar e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>12,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Deudas acumuladas e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>13,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Otros pasivos corrientes e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>14,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Deudas acumuladas e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>15,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Prestamos a largo plazo 1 e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>15,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Prestamos a largo plazo 2 e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>16,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Otros pasivos no corrientes e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>17,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Capital social e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>18,
                'tipo_estado_financiero_id'=>1,
                'nombreCuenta'=>"Utilidades por distribuir e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>19,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Otros valores de capital e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>20,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Gastos de ventas e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>21,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Gastos generales y administrativos e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>22,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Gastos de arrendamiento e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>23,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Gastos de depreciación e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>24,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Otros gastos de operación e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>25,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Costo de los bienes vendidos e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>26,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Otros costos de operacion e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>27,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Ingresos por ventas e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>28,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Otros ingresos de operación e2"
            ],
            [
                'empresa_id'=>2,
                'cuenta_id'=>29,
                'tipo_estado_financiero_id'=>2,
                'nombreCuenta'=>"Descuentos y devoluciones e2"
            ],
        ];

        foreach ($cuentas as $cuenta) {
            \DB::table("cuenta_empresas")->insert($cuenta);
        }

    }
}
