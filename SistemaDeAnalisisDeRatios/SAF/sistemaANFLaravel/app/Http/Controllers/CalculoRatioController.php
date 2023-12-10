<?php

namespace App\Http\Controllers;

use App\Models\CalculoRatio;
use App\Models\Empresa;
use App\Models\Ratio;
use App\Models\SectorEmpresa;
use App\Models\ValorSectorRatio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CalculoRatioController extends Controller
{
    public function getValoresRatiosEmpresa($empresa_id, $year)
    {
        $ratios = CalculoRatio::where("empresa_id", $empresa_id)->where("year", $year)->select("*")->distinct("ratio_id")->with("ratio")->get();

        return (isset($ratios)) ? $ratios : false;
    }

    public function getValoresRatiosVsSector(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'sector' => 'required',
            'year' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        $empresas = Empresa::where('sector_empresa_id',$request->sector)->get();
        $sector = SectorEmpresa::where('id', $request->sector)->with('valorSectorRatio')->first();
        $ratios = Ratio::all();

        $valoresRatiosEmpresas = [];
        $valoresRatiosSector = $sector;

        /*foreach($empresas as $empresa){
            $ratiosEmpresa = (object) [
                'empresa' => $empresa->nombre,
                'ratios' => $empresa->getValoresRatiosEmpresa($request->year)
            ];
            array_push($valoresRatiosEmpresas, $ratiosEmpresa);
        }*/

        foreach ($ratios as $ratio) {
            $valoresRatio = (object) [
                'nombreRatio' => $ratio->nombre,
                'valores' => []
            ];

            $valorRatioSector = ValorSectorRatio::where('ratio_id', $ratio->id)->where('sector_empresa_id', $request->sector)->first();

            foreach ($empresas as $empresa) {
                $valorRatioEmpresa = CalculoRatio::where('ratio_id', $ratio->id)->where('empresa_id', $empresa->id)->where('year', $request->year)->with('empresa')->first();
                if (isset($valorRatioEmpresa)) {
                    $valorRatioEmpresa['evaluacionVsSector'] = ($valorRatioEmpresa->valor > $valorRatioSector->valor);
                }else{
                    $valorRatioEmpresa['valor'] = 0;
                    $valorRatioEmpresa['evaluacionVsSector'] = false;
                }

                array_push($valoresRatio->valores, $valorRatioEmpresa);
            }
            array_push($valoresRatio->valores, $valorRatioSector);
            array_push($valoresRatiosEmpresas, $valoresRatio);
        }

        return response()->json([
            'status' => true,
            'ratiosPorTipo' => $valoresRatiosEmpresas,
            'ratiosSector' => $valoresRatiosSector,
            'empresas' => $empresas
        ]);
    }

    public function getYears(Request $request)
    {

        $years = DB::table('calculo_ratios')
            ->select('calculo_ratios.year')
            ->distinct()
            ->get();

        return response()->json([
            'status' => true,
            'years' => $years
        ], 200);
    }

    public function getValorRatio(Request $request){
        $validator = \Validator::make($request->all(), [
            "empresa" => "required",
            "ratio" => "required",
            "inicio" => "required",
            "fin" => "required"]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        $ratio = Ratio::where('id', $request->ratio)->first();

        $resultado = CalculoRatio::where('empresa_id',$request->empresa)
        ->where('ratio_id','=',$request->ratio)
        ->where('year','>=', $request->inicio)
        ->where('year','<=',$request->fin)
        ->select('year','valor')
        ->get();

        if(isset($resultado)){
            return response()->json([
                'status'=> true,
                'valoresRatio' => $resultado,
                'ratio'=> $ratio
            ]);
        }else{
            return response()->json([
                'status'=> false,
                'message' => "Error al obtener los datos"
            ]);
        }

 }
 
public function getValoresRatiosVsPromedio(Request $request)
{

    $validator = Validator::make($request->all(), [
        'sector' => 'required',
        'year' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        $empresas = Empresa::where('sector_empresa_id', $request->sector)->get();
        $ratios = Ratio::all();

        $suma_ratios_empresas_por_tipo = [];

        foreach ($ratios as $ratio) {
            $suma_ratios_empresas_por_tipo[$ratio->nombre] = 0;
        }

        foreach ($empresas as $empresa) {
            foreach ($ratios as $ratio) {
                $valorRatioEmpresa = CalculoRatio::where('ratio_id', $ratio->id)->where('empresa_id', $empresa->id)->where('year', $request->year)->with('empresa')->first();
                if (isset($valorRatioEmpresa)) {
                    $suma_ratios_empresas_por_tipo[$ratio->nombre] += $valorRatioEmpresa->valor;
                }
            }
        }

        $promedio = [];
        foreach ($ratios as $ratio) {
            $promedio[$ratio->nombre] = $suma_ratios_empresas_por_tipo[$ratio->nombre] / count($empresas);
        }

        $valoresRatiosEmpresas = [];
        foreach ($ratios as $ratio) {
            $valoresRatio = (object) [
                'nombreRatio' => $ratio->nombre,
                'promedio' => $promedio[$ratio->nombre],
                'valores' => []
            ];

            foreach ($empresas as $empresa) {
                $valorRatioEmpresa = CalculoRatio::where('ratio_id', $ratio->id)->where('empresa_id', $empresa->id)->where('year', $request->year)->with('empresa')->first();
                if (isset($valorRatioEmpresa)) {
                    $valorRatioEmpresa['evaluacionVsPromedio'] = ($valorRatioEmpresa->valor >= $promedio[$ratio->nombre]);
                }else{
                    $valorRatioEmpresa['valor'] = 0;
                    $valorRatioEmpresa['evaluacionVsPromedio'] = false;
                }

                array_push($valoresRatio->valores, $valorRatioEmpresa);
            }
            array_push($valoresRatiosEmpresas, $valoresRatio);
        }

        return response()->json([
            'status' => true,
            'ratiosPorTipo' => $valoresRatiosEmpresas,
            'promedio' => $promedio,
            'empresas' => $empresas
        ]);
    }
}
