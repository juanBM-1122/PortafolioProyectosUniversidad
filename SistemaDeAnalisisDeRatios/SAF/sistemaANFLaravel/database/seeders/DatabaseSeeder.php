<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(ClaseCuentaSeeder::class);
        $this->call(SubCuentaSeeder::class);
        $this->call(CuentaSeeder::class);
        $this->call(SectorEmpresaSeeder::class);
        //$this->call(EmpresaSeeder::class);
        $this->call(TipoEstadoFinancieroSeeder::class);
        //$this->call(CuentaEmpresaSeeder::class);
        //$this->call(ValorCuentaSeeder::class);
        $this->call(RatioSeeder::class);
        $this->call(CalculoRatioSeeder::class);
        $this->call(ValorSectorRatioSeeder::class);

        DB::statement("INSERT INTO empresas (id, created_at, updated_at, sector_empresa_id, nombre) VALUES
    (1, '2023-11-08 07:17:53', '2023-11-08 07:17:53', 1, 'Walmart'),
    (2, '2023-11-08 08:27:21', '2023-11-08 08:27:21', 2, 'McDonalds'),
    (3, '2023-11-08 08:37:36', '2023-11-08 08:37:36', 1, 'Costco'),
    (4, '2023-11-08 08:49:37', '2023-11-08 08:49:37', 2, 'Wendys')");

    DB::statement("INSERT INTO `cuenta_empresas` (`id`, `created_at`, `updated_at`, `empresa_id`, `cuenta_id`, `tipo_estado_financiero_id`, `nombreCuenta`) VALUES
    (1, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 1, 1, 'Efectivo y equivalentes de efectivo'),
    (2, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 2, 1, 'Cuentas por cobrar neto'),
    (3, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 3, 1, 'Inventarios'),
    (4, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 8, 1, 'Pagos anticipados y otros'),
    (5, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 6, 1, 'Inmuebles y equipo neto'),
    (6, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 9, 1, 'Activos por derecho de uso'),
    (7, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 9, 1, 'Arrendamiento financiero neto'),
    (8, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 9, 1, 'Propiedades de inversión neto'),
    (9, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 9, 1, 'Activos intangibles neto'),
    (10, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 9, 1, 'Activos por impuestos diferidos'),
    (11, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 9, 1, 'Otros activos no circulantes'),
    (12, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 10, 1, 'Cuentas por pagar'),
    (13, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 13, 1, 'Pasivos por arrendamiento a corto plazo'),
    (14, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 10, 1, 'Otras cuentas por pagar'),
    (15, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 13, 1, 'Impuestos a la utilidad'),
    (16, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 16, 1, 'Pasivos por arrendamiento y otros pasivos a largo plazo'),
    (17, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 16, 1, 'Pasivos por impuestos diferidos'),
    (18, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 16, 1, 'Beneficios a los empleados'),
    (19, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 17, 1, 'Capital social'),
    (20, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 18, 1, 'Utilidades acumuladas'),
    (21, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 19, 1, 'Otras partidas de utilidad integral'),
    (22, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 19, 1, 'Prima en venta de acciones'),
    (23, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 19, 1, 'Fondo para el plan de acciones al personal'),
    (24, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 27, 2, 'Ventas netas'),
    (25, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 28, 2, 'Otros ingresos'),
    (26, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 28, 2, 'Ingresos financieros'),
    (27, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 20, 2, 'Gastos generales'),
    (28, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 21, 2, 'Gastos financieros'),
    (29, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 24, 2, 'Otros gastos'),
    (30, '2023-11-08 01:17:53', '2023-11-08 01:17:53', 1, 25, 2, 'Costo de ventas'),
    (32, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 1, 1, 'Caja y equivalentes de caja'),
    (33, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 5, 1, 'Otras inversiones a corto plazo'),
    (34, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 5, 1, 'Cuentas pendientes netas'),
    (35, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 3, 1, 'Inventario'),
    (36, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 5, 1, 'Otros activos circulantes'),
    (37, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 6, 1, 'Propiedad bruta  planta y equipo'),
    (38, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 7, 1, 'Depreciación acumulada'),
    (39, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 9, 1, 'Propiedad neta planta y equipo'),
    (40, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 9, 1, 'Otros activos a largo plazo'),
    (41, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 10, 1, 'Deuda corriente'),
    (42, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 10, 1, 'Cuentas a pagar'),
    (43, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 13, 1, 'Obligaciones devengadas'),
    (44, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 13, 1, 'Otros pasivos circulantes'),
    (45, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 15, 1, 'Deuda a largo plazo'),
    (46, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 16, 1, 'Otras obligaciones a largo'),
    (47, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 17, 1, 'Acción ordinaria'),
    (48, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 18, 1, 'Ganancias retenidas'),
    (49, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 19, 1, 'Otro ingreso integral acumulado'),
    (50, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 27, 2, 'Ingresos totales'),
    (51, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 24, 2, 'Gastos operativos totales'),
    (52, '2023-11-08 02:27:21', '2023-11-08 02:27:21', 2, 26, 2, 'Costo de ganancias'),
    (53, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 1, 1, 'Caja y equivalentes de caja'),
    (54, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 5, 1, 'Otras inversiones a corto plazo'),
    (55, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 3, 1, 'Inventario'),
    (56, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 2, 1, 'Cuentas pendientes netas'),
    (57, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 5, 1, 'Otros activos circulantes'),
    (58, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 6, 1, 'Propiedad bruta  planta y equipo'),
    (59, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 7, 1, 'Depreciación acumulada'),
    (60, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 9, 1, 'Otros activos a largo plazo'),
    (61, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 10, 1, 'Deuda corriente'),
    (62, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 10, 1, 'Cuentas a pagar'),
    (63, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 13, 1, 'Obligaciones devengadas'),
    (64, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 13, 1, 'Otros pasivos circulantes'),
    (65, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 14, 1, 'Otras obligaciones a largo'),
    (66, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 16, 1, 'Deuda a largo plazo'),
    (67, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 17, 1, 'Acción ordinaria'),
    (68, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 18, 1, 'Ganancias retenidas'),
    (69, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 19, 1, 'Otro ingreso integral acumulado'),
    (70, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 27, 2, 'Ingresos totales'),
    (71, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 21, 2, 'Gastos de interés'),
    (72, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 24, 2, 'Gastos operativos totales'),
    (73, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 25, 2, 'Costo de ganancias'),
    (74, '2023-11-08 02:37:36', '2023-11-08 02:37:36', 3, 26, 2, 'Otros Costos De Operación'),
    (75, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 1, 1, 'Efectivo y equivalentes de efectivo'),
    (76, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 2, 1, 'Cuentas por cobrar neto'),
    (77, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 3, 1, 'Inventarios'),
    (78, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 5, 1, 'Pagos anticipados y otros'),
    (79, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 6, 1, 'Inmuebles y equipo neto'),
    (80, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 9, 1, 'Activos por derecho de uso'),
    (81, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 9, 1, 'Arrendamiento financiero neto'),
    (82, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 9, 1, 'Propiedades de inversión neto'),
    (83, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 9, 1, 'Activos intangibles neto'),
    (84, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 9, 1, 'Activos por impuestos diferidos'),
    (85, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 9, 1, 'Otros activos no circulantes'),
    (86, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 10, 1, 'Cuentas por pagar'),
    (87, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 13, 1, 'Pasivos por arrendamiento a corto plazo'),
    (88, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 10, 1, 'Otras cuentas por pagar'),
    (89, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 13, 1, 'Impuestos a la utilidad'),
    (90, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 16, 1, 'Pasivos por arrendamiento y otros pasivos a largo plazo'),
    (91, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 16, 1, 'Pasivos por impuestos diferidos'),
    (92, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 16, 1, 'Beneficios a los empleados'),
    (93, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 17, 1, 'Capital social'),
    (94, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 18, 1, 'Utilidades acumuladas'),
    (95, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 19, 1, 'Otras partidas de utilidad integral'),
    (96, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 19, 1, 'Prima en venta de acciones'),
    (97, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 19, 1, 'Fondo para el plan de acciones al personal'),
    (98, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 27, 2, 'Ventas netas'),
    (99, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 28, 2, 'Otros ingresos'),
    (100, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 21, 2, 'Gastos generales'),
    (101, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 24, 2, 'Otros gastos'),
    (102, '2023-11-08 02:49:37', '2023-11-08 02:49:37', 4, 21, 2, 'Gastos financieros'),
    (103, '2023-11-08 02:49:38', '2023-11-08 02:49:38', 4, 25, 2, 'Costo de los bienes vendidos'),
    (104, '2023-11-08 02:49:38', '2023-11-08 02:49:38', 4, 26, 2, 'Otros Costos De Operación');");

    }
}
