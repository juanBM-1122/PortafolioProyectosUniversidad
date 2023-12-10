<?php

namespace App\Http\Controllers;

use App\Models\SectorEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectorEmpresaController extends Controller
{
    public function index()
    {
      
        return  SectorEmpresa::all();
    }

    public function getSectores()
    {
        $sectores = SectorEmpresa::all();

        return response()->json([
            'status' => true,
            'sectores' => $sectores
        ],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:sector_empresas',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        $sector = new SectorEmpresa();
        $sector->nombre = $request->nombre;
        $sector->save();

        return response()->json([
            'status' => true,
            'message' => 'Sector creado correctamente'
        ]);
    }

    public function update(Request $request, SectorEmpresa $sector)
    {
        
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:sector_empresas',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        $sector = SectorEmpresa::find($sector->id);

        if ($request->nombre != $sector->nombre){
            $sector->nombre = $request->nombre;
        }
        $sector->update();

        return response()->json([
            'status' => true,
            'message' => 'Sector actualizado correctamente',
            'data' => $sector,
        ]);
    }

    public function destroy($id)
    {
        if ($id){
            $sector = SectorEmpresa::find($id);
            $sector->delete();
            return response()->json([
                'status'=> true,                
                'message'=> 'Sector eliminado correctamente',
                'data' => $id,
            ],200);
        }
        else{
            return response()->json([
                'status'=> false,
                'message'=> 'Error al eliminar el sector',
            ],400);
        }
    }
}
