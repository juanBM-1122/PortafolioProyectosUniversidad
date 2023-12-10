<?php

namespace App\Http\Controllers;

use App\Models\CalculoRatio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Empresa;
use App\Models\ValorCuenta;


class EstadoFinancieroController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make(
            $request->all(),[
            "empresaId"=>"int|required",
            "year"=>"int|required",
            "valoresCuentaEmpresa"=>"array|required"
            ]
        );

        if($validator->fails()){
           return response()->json([
                "status"=>false,
                "errores"=>$validator->errors()->all(),
            ],400);
        }

        $valoresCuentaEstadoFinanciero = $validator->validated();
        $this->borrarValoresCuentas($valoresCuentaEstadoFinanciero["empresaId"],$valoresCuentaEstadoFinanciero["year"]);

        $valoresGuardados = $this->guardarValoresCuenta($valoresCuentaEstadoFinanciero["valoresCuentaEmpresa"],$valoresCuentaEstadoFinanciero["year"]);

        $empresa = Empresa::where("id",$request->empresaId)->first();
        $ratiosFinancieros = [
            $empresa->getLiquidezCorriente($request->year),
            $empresa->getPruebaAcida($request->year),
            $empresa->getRazonCapitalTrabajo($request->year),
            $empresa->getRazonEfectivo($request->year),
            $empresa->getRazonRotacionInventario($request->year),
            $empresa->getRazonDiasInventario($request->year),
            $empresa->getRazonRotacionCuentasPorCobrar($request->year),
            $empresa->getPeriodoMedioCobranza($request->year),
            $empresa->getRotacionCuentasPorPagar($request->year),
            $empresa->getPeriodoMedioPago($request->year),
        ];

        $i = 1;
        foreach ($ratiosFinancieros as $ratio) {
            CalculoRatio::insert([
                "ratio_id" => $i,
                "empresa_id" => $empresa->id,
                "valor" => $ratio,
                "year" => $request->year
            ]);
            $i++;
        }

        return response()->json([
            "status"=>true,
            "mensaje"=>"Valores cuenta guardadas con éxito",
        ]);
    }

    //Metodo que sirve para verificar que no existan valor cuentas para ese periodo
    public function verificarSiExistenValorCuentasParaAnio($empresaId,$year){
        $valorCuentaEmpresaAnio = Empresa::join("cuenta_empresas","empresas.id","=","cuenta_empresas.empresa_id")
        ->join("valor_cuentas","cuenta_empresas.id","=","valor_cuentas.cuenta_empresa_id")
        ->select('*')
        ->where("empresas.id","=",$empresaId)
        ->where("valor_cuentas.year","=",$year)
        ->get();

        return $valorCuentaEmpresaAnio;
    }

    public function borrarValoresCuentas($empresaId,$year):void{
        ValorCuenta::where('year', $year)
        ->whereHas('cuentaEmpresa', function ($q) use ($empresaId) {
            $q->where('empresa_id', $empresaId);
        })->delete();
    }

    public function guardarValoresCuenta($valoresCuentasEmpresa,$year){
        foreach($valoresCuentasEmpresa as $valor){
         $tempValorCuenta = new ValorCuenta();
         $tempValorCuenta->cuenta_empresa_id = $valor["cuenta_empresa_id"];
         $tempValorCuenta->valorCuenta = $valor["valorCuenta"];
         $tempValorCuenta->year = $year;
         $tempValorCuenta->save();
        }
    }
}
