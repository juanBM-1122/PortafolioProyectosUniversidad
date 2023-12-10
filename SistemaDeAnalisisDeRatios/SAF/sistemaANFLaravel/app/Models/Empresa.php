<?php

namespace App\Models;

use App\Http\Controllers\CalculoRatioController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Empresa extends Model
{


    //Constantes de ClaseCuenta
    const ACTIVOS = "Activos";
    const PASIVOS = "Pasivos";
    const PATRIMONIO = "Patrimonio";
    const GASTOS = "Gastos";
    const COSTOS = "Costos";
    const INGRESOS = "Ingresos";

    //Constantes de SubCuenta

    const COMPRAS = "Costos de operacion";
    const PASIVOS_CORRIENTES = "Pasivos corrientes";
    const ACTIVOS_CORRIENTES = "Activos corrientes";
    const ACTIVO_FIJO = "Activos no corrientes";
    //Contanstes de Cuenta
    const EFECTIVO_Y_EQUIVALENTES = "Efectivo y equivalentes";
    const INVENTARIO = "Inventario";
    const COSTO_DE_VENTAS = "Costo de los bienes vendidos";
    const CUENTAS_POR_COBRAR = "Cuentas por cobrar";
    const CUENTAS_POR_PAGAR = "Cuentas por pagar";
    const INGRESOS_POR_VENTAS = "Ingresos por ventas";
    const DESCUENTOS_Y_DEVOLUCIONES = "Descuentos y devoluciones";

    use HasFactory;
    protected $fillable = [
        "sector_empresa_id",
        "nombre"
    ];

    public function sector()
    {
        return $this->belongsTo(SectorEmpresa::class);
    }

    public function getCuentasEmpresa()
    {
        return $this->hasMany(CuentaEmpresa::class);
    }
    public function getCuentasPorClase($claseCuenta)
    {

        $activos = CuentaEmpresa::join('cuentas', 'cuenta_empresas.cuenta_id', '=', 'cuentas.id')
            ->join('sub_cuentas', 'cuentas.sub_cuenta_id', '=', 'sub_cuentas.id')
            ->join('clase_cuentas', 'sub_cuentas.clase_cuenta_id', '=', 'clase_cuentas.id')
            ->where('clase_cuentas.nombre', $claseCuenta)
            ->where('cuenta_empresas.empresa_id', $this->id)
            ->select('cuenta_empresas.*') // Selecciona todos los atributos de la tabla cuenta_empresas
            ->get();


        return $activos;
    }

    public function getYearsConEstadosFinancieros(){
        return DB::table('valor_cuentas')
        ->join('cuenta_empresas', 'valor_cuentas.cuenta_empresa_id', '=', 'cuenta_empresas.id')
        ->where('cuenta_empresas.empresa_id', $this->id)
        ->select('valor_cuentas.year')
        ->distinct()
        ->get();
    }

    public function getTotalClaseCuenta($year, $nombreClaseCuenta)
    {
        $clase_cuenta = ClaseCuenta::where('nombre', $nombreClaseCuenta)->first();
        return $clase_cuenta->getTotal($year, $this->id);
    }

    public function getTotalSubCuenta($year, $nombreSubCuenta, )
    {
        $sub_cuenta = SubCuenta::where("nombre", $nombreSubCuenta)->first();
        return $sub_cuenta->getTotal($year, $this->id);
    }

    public function getTotalCuenta($year, $nombreCuenta)
    {
        $cuenta = Cuenta::where("nombre", $nombreCuenta)->first();
        return $cuenta->getTotal($year, $this->id);
    }

    public function getPromedioCuenta($year,$nombreCuenta)
    {
        $cuenta = Cuenta::where("nombre", $nombreCuenta)->first();
        return $cuenta->getPromedio($year,$this->id);
    }

    public function getValoresRatiosEmpresa($year)
    {
        $calculoRatioController = new CalculoRatioController;
        $ratios = $calculoRatioController->getValoresRatiosEmpresa($this->id, $year);
        return $ratios;
    }

    //FUNCIONES PARA CALCULO DE RATIOS
    public function getLiquidezCorriente($year)
    {
        //1
        $activos_corrientes = $this->getTotalSubCuenta($year, self::ACTIVOS_CORRIENTES);
        $pasivos_corrientes = $this->getTotalSubCuenta($year, self::PASIVOS_CORRIENTES);

        $liquidez_corriente = $activos_corrientes / $pasivos_corrientes;

        return $liquidez_corriente;
    }

    public function getPruebaAcida($year)
    {
        //2
        $activos_corrientes = $this->getTotalSubCuenta($year, self::ACTIVOS_CORRIENTES);
        $pasivos_corrientes = $this->getTotalSubCuenta($year, self::PASIVOS_CORRIENTES);
        $inventario = $this->getTotalCuenta($year, "Inventario");

        //$prueba_acida = ($activos_corrientes - $inventario) / $pasivos_corrientes;

        //return $prueba_acida;
        return ($pasivos_corrientes != 0)? ($activos_corrientes - $inventario) / $pasivos_corrientes:false;
    }
    public function getRazonCapitalTrabajo($year)
    {
        //3
        $activos_corrientes = $this->getTotalSubCuenta($year, self::ACTIVOS_CORRIENTES);
        $pasivos_corrientes = $this->getTotalSubCuenta($year, self::PASIVOS_CORRIENTES);
        $activos_totales = $this->getTotalClaseCuenta($year, self::ACTIVOS);

       // $razon_capital_trabajo = ($activos_corrientes - $pasivos_corrientes) / $activos_totales;
        return ($activos_totales != 0)? ($activos_corrientes - $pasivos_corrientes) / $activos_totales:false;
    }

    public function getRazonEfectivo($year)
    {
        //4 - Efectivo + Valores de corto plazo / p. corrientes
        $efectivo_y_equivalentes = $this->getTotalCuenta($year, self::EFECTIVO_Y_EQUIVALENTES);
        $pasivos_corrientes = $this->getTotalSubCuenta($year, self::PASIVOS_CORRIENTES);

        //return $efectivo_y_equivalentes / $pasivos_corrientes;
        return ($pasivos_corrientes != 0)? $efectivo_y_equivalentes / $pasivos_corrientes:false;
    }

    public function getRazonRotacionInventario($year)
    {
        //5 - costo de ventas / inventario promedio
        $costo_de_venta = $this->getTotalCuenta($year, self::COSTO_DE_VENTAS);
        $inventario_promedio = $this->getPromedioCuenta($year,self::INVENTARIO);
        return ($inventario_promedio != 0 )? $costo_de_venta / $inventario_promedio : false;
    }
    public function getRazonDiasInventario($year)
    {
        //6 - Inventario Promedio / (Costo de ventas/365)
        $costo_de_venta = $this->getTotalCuenta($year, self::COSTO_DE_VENTAS);
        $inventario_promedio = $this->getPromedioCuenta($year,self::INVENTARIO);
        return ($costo_de_venta != 0)? $inventario_promedio / $costo_de_venta * 365:false;
    }

    public function getRazonRotacionCuentasPorCobrar($year)
    {
        //7 - ventas netas / prom cuetas por cobrar comerciales
        $ventas_netas = $this->getTotalCuenta($year, self::INGRESOS_POR_VENTAS) - $this->getTotalCuenta($year,self::DESCUENTOS_Y_DEVOLUCIONES);
        $promedio_cuentas_por_cobrar = $this->getPromedioCuenta($year,self::CUENTAS_POR_COBRAR);
        return ($promedio_cuentas_por_cobrar != 0)? $ventas_netas / $promedio_cuentas_por_cobrar : false;
    }

    public function getPeriodoMedioCobranza($year)
    {
        //8 - prom. Cuentas por cobrar x 365 / ventas netas
        $promedio_cuentas_por_cobrar = $this->getPromedioCuenta($year,self::CUENTAS_POR_COBRAR);
        $ventas_netas = $this->getTotalCuenta($year, self::INGRESOS_POR_VENTAS) - $this->getTotalCuenta($year,self::DESCUENTOS_Y_DEVOLUCIONES);
        
        return ($ventas_netas != 0)? $promedio_cuentas_por_cobrar/$ventas_netas *365 : false;
    }
    public function getRotacionCuentasPorPagar($year)
    {
        // 9 - compras / prom. cuentas por pagar comerciales
        $compras = $this->getTotalSubCuenta($year,self::COMPRAS);
        $promedio_cuentas_por_pagar = $this->getPromedioCuenta($year,self::CUENTAS_POR_PAGAR);
        return ($promedio_cuentas_por_pagar)? $compras/$promedio_cuentas_por_pagar:false;
    }
    public function getPeriodoMedioPago($year)
    {
        //10 - prom. cuentas por pagar x 365 / compras
        $compras = $this->getTotalSubCuenta($year,self::COMPRAS);
        $promedio_cuentas_por_pagar = $this->getPromedioCuenta($year,self::CUENTAS_POR_PAGAR);
        return ($compras != 0)? ($promedio_cuentas_por_pagar/$compras)*365 : false;
    }

}
