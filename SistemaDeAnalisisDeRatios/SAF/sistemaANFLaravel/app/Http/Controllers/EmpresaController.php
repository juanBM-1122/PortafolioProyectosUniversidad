<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{

    public function obtenerEmpresasRegistradas(){
        return Empresa::all();
    }

    public function index(){
        return Empresa::with('getCuentasEmpresa')->get();
    }
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }
    
        $empresa = new Empresa();
        $empresa->nombre = $request->nombre;
        $empresa->sector_empresa_id = $request->sector_empresa_id;
        // Agrega otros campos de empresa según sea necesario
    
        $empresa->save();
    
        return response()->json([
            'status' => true,
            'message' => 'Empresa creada correctamente',
            'empresa' => $empresa
        ]);
    }
    public function ultima()
    {
        $ultimoRegistro = Empresa::latest('id')->first();
    return response()->json(['empresa_id' => $ultimoRegistro->id]);
    }

    public function show($id){
        return Empresa::with('getCuentasEmpresa', 'getCuentasEmpresa.valoresCuenta')->find($id);
    }

    public function aniosConEstadosFinancieros(Request $request){
        $validator = Validator::make($request->all(), [
            'empresa' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        $empresa = Empresa::find($request->empresa);
        $years = $empresa->getYearsConEstadosFinancieros();
        if($empresa){
            return response()->json([
                'status'=> true,
                'years'=>$years,
            ]);
        }
    }
}
