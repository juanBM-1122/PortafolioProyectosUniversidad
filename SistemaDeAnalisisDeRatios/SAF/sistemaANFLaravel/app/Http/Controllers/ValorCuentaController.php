<?php

namespace App\Http\Controllers;

use App\Models\CuentaEmpresa;
use App\Models\ValorCuenta;
use Illuminate\Http\Request;

class ValorCuentaController extends Controller
{
    public function obtenerAniosUnicos(Request $request)
    {

        $aniosUnicos = ValorCuenta::select("year")
            ->distinct()
            ->get();

        return $aniosUnicos;
    }

    public function obtenerAniosUnicosPorEmpresa(Request $request){
        $idEmpresa  = $request->input("empresaId");
        $aniosValoresEmpresa = ValorCuenta::whereHas("cuentaEmpresa",function ($q) use ($idEmpresa){
            $q->where("empresa_id","=",$idEmpresa);
        })->select("year")->distinct()->get();

        return $aniosValoresEmpresa;
    }

    public function getValoresCuenta(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            "empresa" => "required",
            "cuenta" => "required",
            "inicio" => "required",
            "fin" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ]);
        }
        $cuenta = CuentaEmpresa::where('id',$request->cuenta)->first();

        $resultado = ValorCuenta::join('cuenta_empresas', 'valor_cuentas.cuenta_empresa_id', '=', 'cuenta_empresas.id')
            ->where('cuenta_empresas.empresa_id', $request->empresa)
            ->where('valor_cuentas.year', '>=', $request->inicio)
            ->where('valor_cuentas.year', '<=', $request->fin)
            ->where('cuenta_empresas.id', $request->cuenta)
            ->select('valor_cuentas.year','valor_cuentas.valorCuenta as valor')
            ->get();

        if(isset($resultado)){
            return response()->json([
                'status'=> true,
                'valoresCuenta' => $resultado,
                'cuenta' => $cuenta
            ]);
        }else{
            return response()->json([
                'status'=> false,
                'message' => "Error al obtener los datos"
            ]);
        }
    }
}
