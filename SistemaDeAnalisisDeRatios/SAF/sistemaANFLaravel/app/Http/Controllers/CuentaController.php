<?php

namespace App\Http\Controllers;

use App\Models\ValorCuenta;
use Illuminate\Http\Request;
use App\Models\Cuenta;

class CuentaController extends Controller
{
    const ACTIVOS = "Activos";
    const PASIVOS = "Pasivos";
    const PATRIMONIO = "Patrimonio";
    const GASTOS = "Gastos";
    const COSTOS = "Costos";
    const INGRESOS = "Ingresos";
    public function index()
    {

        return Cuenta::all();
    }
    public function getCuentasClasificadasPorClase(Request $request)
    {
        $activos = Cuenta::join('sub_cuentas', 'cuentas.sub_cuenta_id', '=', 'sub_cuentas.id')
            ->join('clase_cuentas', 'sub_cuentas.clase_cuenta_id', '=', 'clase_cuentas.id')
            ->where('clase_cuentas.nombre', self::ACTIVOS)
            ->select('cuentas.*') // Selecciona todos los atributos de la tabla cuenta_empresas
            ->get();

        $pasivos = Cuenta::join('sub_cuentas', 'cuentas.sub_cuenta_id', '=', 'sub_cuentas.id')
            ->join('clase_cuentas', 'sub_cuentas.clase_cuenta_id', '=', 'clase_cuentas.id')
            ->where('clase_cuentas.nombre', self::PASIVOS)
            ->select('cuentas.*') // Selecciona todos los atributos de la tabla cuenta_empresas
            ->get();
        $patrimonio = Cuenta::join('sub_cuentas', 'cuentas.sub_cuenta_id', '=', 'sub_cuentas.id')
            ->join('clase_cuentas', 'sub_cuentas.clase_cuenta_id', '=', 'clase_cuentas.id')
            ->where('clase_cuentas.nombre', self::PATRIMONIO)
            ->select('cuentas.*') // Selecciona todos los atributos de la tabla cuenta_empresas
            ->get();
        $ingresos = Cuenta::join('sub_cuentas', 'cuentas.sub_cuenta_id', '=', 'sub_cuentas.id')
            ->join('clase_cuentas', 'sub_cuentas.clase_cuenta_id', '=', 'clase_cuentas.id')
            ->where('clase_cuentas.nombre', self::INGRESOS)
            ->select('cuentas.*') // Selecciona todos los atributos de la tabla cuenta_empresas
            ->get();
        $gastos = Cuenta::join('sub_cuentas', 'cuentas.sub_cuenta_id', '=', 'sub_cuentas.id')
            ->join('clase_cuentas', 'sub_cuentas.clase_cuenta_id', '=', 'clase_cuentas.id')
            ->where('clase_cuentas.nombre', self::GASTOS)
            ->select('cuentas.*') // Selecciona todos los atributos de la tabla cuenta_empresas
            ->get();
        $costos = Cuenta::join('sub_cuentas', 'cuentas.sub_cuenta_id', '=', 'sub_cuentas.id')
            ->join('clase_cuentas', 'sub_cuentas.clase_cuenta_id', '=', 'clase_cuentas.id')
            ->where('clase_cuentas.nombre', self::COSTOS)
            ->select('cuentas.*') // Selecciona todos los atributos de la tabla cuenta_empresas
            ->get();

        $cuentas = [
            'activos' => $activos,
            'pasivos' => $pasivos,
            'patrimonio' => $patrimonio,
            'ingresos' => $ingresos,
            'gastos' => $gastos,
            'costos' => $costos,
        ];

        return response()->json([
            'cuentas' => $cuentas
        ], 200);
    }
    public function create()
    {
    }

    // Almacenar un nuevo recurso en la base de datos
    public function store(Request $request)
    {
        // Valida y almacena los datos del nuevo sector
    }

    // Mostrar un recurso específico
    public function show($id)
    {
    }

    // Mostrar el formulario para editar un recurso existente
    public function edit($id)
    {
    }

    // Actualizar un recurso existente en la base de datos
    public function update(Request $request, $id)
    {
        // Valida y actualiza los datos del sector
    }

    // Eliminar un recurso específico de la base de datos
    public function destroy($id)
    {
        // Elimina el sector
    }

    public function getTotalCuenta($year, $empresa_id, $cuenta)
    {

        $total_cuenta = ValorCuenta::join('cuenta_empresas', 'valor_cuentas.cuenta_empresa_id', '=', 'cuenta_empresas.id')
            ->join('cuentas', 'cuenta_empresas.cuenta_id', '=', 'cuentas.id')
            ->join('empresas', 'cuenta_empresas.empresa_id', '=', 'empresas.id')
            ->where('cuentas.nombre', $cuenta)
            ->where('valor_cuentas.year', $year)
            ->where('empresas.id', $empresa_id)
            ->sum('valor_cuentas.valorCuenta');
        //->value(\DB::raw('COALESCE(SUM(valor_cuentas.valorCuenta), 0)'));

        if ($total_cuenta == null) {
            return 0;
        }

        return $total_cuenta;
    }

    public function getPromedioCuenta($year, $empresa_id, $cuenta)
    {
        $years = ValorCuenta::join('cuenta_empresas', 'valor_cuentas.cuenta_empresa_id', '=', 'cuenta_empresas.id')
            ->join('cuentas', 'cuenta_empresas.cuenta_id', '=', 'cuentas.id')
            ->join('empresas', 'cuenta_empresas.empresa_id', '=', 'empresas.id')
            ->where('cuentas.nombre', $cuenta)
            ->where('valor_cuentas.year', '<=', $year)
            ->where('empresas.id', $empresa_id)
            ->select('valor_cuentas.year as year')
            ->distinct()
            ->get();

        $listaTotalesCuenta = [];

        foreach ($years as $anio) {
            $totalCuenta = $this->getTotalCuenta($anio->year, $empresa_id, $cuenta);
            array_push($listaTotalesCuenta, $totalCuenta);
        }

        //$promedioValorCuenta = array_sum($listaTotalesCuenta) / count($listaTotalesCuenta);
        $promedioValorCuenta = ( count($listaTotalesCuenta) != 0)? array_sum($listaTotalesCuenta) / count($listaTotalesCuenta): 0;

        if ($promedioValorCuenta == null) {
            return 0;
        }

        return $promedioValorCuenta;
    }

}
