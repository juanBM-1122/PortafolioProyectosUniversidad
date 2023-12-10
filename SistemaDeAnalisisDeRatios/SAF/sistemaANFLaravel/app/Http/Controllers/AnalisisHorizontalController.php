<?php

namespace App\Http\Controllers;

use App\Models\AnalisisHorizontal;
use App\Models\Empresa;
use App\Models\ValorCuenta;
use DB;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;

class AnalisisHorizontalController extends Controller
{

    const ACTIVOS = 'Activos';
    const PASIVOS = 'Pasivos';
    const PATRIMONIO = 'Patrimonio';
    const GASTOS = 'Gastos';
    const COSTOS = 'Costos';
    const INGRESOS = 'Ingresos';

    public function index()
    {

    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {

    }

    public function showAnalisisHorizontal(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'empresa' => 'required',
            'yearInicial' => 'required',
            'yearFinal' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        $primer_anio_analisis = $request->yearInicial;
        $ultimo_anio_analisis = $request->yearFinal;

        $empresa = Empresa::where('id', $request->empresa)->first();

        /*$ratiosFinancieros = (object) [
            "pruebaAcida" => $pruebaAcida = $empresa->getPruebaAcida(2021),
            "liquidezCorriente" => $liquidezCorriente = $empresa->getLiquidezCorriente(2021),
            "razonCapitalTrabajo" => $razonCapitalTrabajo = $empresa->getRazonCapitalTrabajo(2021),
        ];*/
        //$ratiosFinancieros = $empresa->getValoresRatiosEmpresa(2021);
        $ratiosFinancieros = [
            'razonCirculante' => $empresa->getLiquidezCorriente($request->yearInicial),
            'pruebaAcida' => $empresa->getPruebaAcida($request->yearInicial),
            'CapitalTrabajo' => $empresa->getRazonCapitalTrabajo($request->yearInicial),
            'razonEfectivo'=> $empresa->getRazonEfectivo($request->yearInicial),
            'rotacionInventario'=> $empresa->getRazonRotacionInventario($request->yearInicial),
            'diasInventario'=> $empresa->getRazonDiasInventario($request->yearInicial),
            'rotacionCuentasCobrar'=> $empresa->getRazonRotacionCuentasPorCobrar($request->yearInicial),
            'periodoMedioCobranza'=> $empresa->getPeriodoMedioCobranza($request->yearInicial),
            'rotacionCuentasPagar'=> $empresa->getRotacionCuentasPorPagar($request->yearInicial),
            'periodoMedioPago'=> $empresa->getPeriodoMedioPago($request->yearInicial),
        ];

        $cuentas = [
            $activos = $empresa->getCuentasPorClase(self::ACTIVOS),
            $pasivos = $empresa->getCuentasPorClase(self::PASIVOS),
            $patrimonio = $empresa->getCuentasPorClase(self::PATRIMONIO),

            //cuentas de resultados
            $ingresos = $empresa->getCuentasPorClase(self::INGRESOS),
            $gastos = $empresa->getCuentasPorClase(self::GASTOS),
            $costos = $empresa->getCuentasPorClase(self::COSTOS),
        ];

        $analisisHorizontales = [];

        for ($primer_anio_analisis; $primer_anio_analisis < $ultimo_anio_analisis; $primer_anio_analisis++) {
            $periodo = [
                'seccion' => [],
            ];
            $periodo["anio_1"] = (integer) $primer_anio_analisis;
            $periodo["anio_2"] = $primer_anio_analisis + 1;

            $indexPeriodo = 0;
            foreach ($cuentas as $cuentasPorTipo) {
                if (isset($cuentasPorTipo) && count($cuentasPorTipo) > 0) {
                    $seccion = $this->getAnalisisPorPeriodo($cuentasPorTipo, $primer_anio_analisis);
                    array_push($periodo['seccion'], $seccion);
                }
            }
            array_push($analisisHorizontales, $periodo);

            $indexPeriodo++;

        }

        return response()->json([
            'status' => true,
            'analisisHorizontalList' => $analisisHorizontales,
            'ratios' => $ratiosFinancieros
        ], 200);
    }

    public function getAnalisisPorPeriodo($cuentas, $primer_anio_analisis)
    {

        $periodo = [];

        foreach ($cuentas as $cuenta) {
            $valor_first = $cuenta->valoresCuenta()->where('year', $primer_anio_analisis)->first();
            $valor_next = $cuenta->valoresCuenta()->where('year', $primer_anio_analisis + 1)->first();

            $fila = [
                'nombre_cuenta' => $cuenta->nombreCuenta,
                'anio_first' => $valor_first->year,
                'anio_next' => $valor_next->year,
                'valor_anio_uno' => $cuenta->valoresCuenta()->where('year', $primer_anio_analisis)->first()->valorCuenta,
                'valor_anio_dos' => $cuenta->valoresCuenta()->where('year', $primer_anio_analisis + 1)->first()->valorCuenta,
                'variacion_absoluta' => $this->calcularVarAbsoluta($valor_first->valorCuenta, $valor_next->valorCuenta),
                'variacion_relativa' => $this->calcularVarRelativa($valor_first->valorCuenta, $valor_next->valorCuenta)
            ];
            array_push($periodo, $fila);
        }
        $filaTotalClaseCuenta = [
            //Para la fila donde se muestran los totales ej. totalActivos
            'nombre_cuenta' => 'Total ' . $cuenta->getClase()->nombre,
            'anio_first' => $valor_first->year,
            'anio_next' => $valor_next->year,
            'valor_anio_uno' => $cuenta->getClase()->getTotal($valor_first->year, $cuenta->empresa_id),
            'valor_anio_dos' => $cuenta->getClase()->getTotal($valor_next->year, $cuenta->empresa_id),
            'variacion_absoluta' => $this->calcularVarAbsoluta($cuenta->getClase()->getTotal($valor_first->year, $cuenta->empresa_id), $cuenta->getClase()->getTotal($valor_next->year, $cuenta->empresa_id)),
            'variacion_relativa' => $this->calcularVarRelativa($cuenta->getClase()->getTotal($valor_first->year, $cuenta->empresa_id), $cuenta->getClase()->getTotal($valor_next->year, $cuenta->empresa_id)) //(($valor_next->valorCuenta / $valor_first->valorCuenta) - 1) * 100,

        ];
        array_push($periodo, $filaTotalClaseCuenta);

        return $periodo;
    }

    public function calcularVarAbsoluta($valor_first_year, $valor_next_year)
    {
        return $valor_next_year - $valor_first_year;
    }
    public function calcularVarRelativa($valor_first_year, $valor_next_year)
    {
        return (($valor_next_year / $valor_first_year) - 1) * 100;
    }
}
