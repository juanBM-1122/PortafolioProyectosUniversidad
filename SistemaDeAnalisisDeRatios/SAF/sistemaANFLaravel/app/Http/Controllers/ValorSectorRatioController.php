<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ValorSectorRatio;
use App\Models\SectorEmpresa;
use Illuminate\Support\Facades\Validator;

class ValorSectorRatioController extends Controller
{
    //
    public function index(Request $request)
    {
        $valorRatioSector = ValorSectorRatio::all();
        return response()->json([
            'status' => true,
            'valorSector' => $valorRatioSector
        ],200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        foreach ($data as $item) {
            $validator = Validator::make($item, [
                'valor' => 'required|numeric',
                'sector_empresa_id' => 'required',
                'ratio_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->all()
                ], 400);
            }

            $valorSector = new ValorSectorRatio();
            $valorSector->valor = $item['valor'];
            $valorSector->sector_empresa_id = $item['sector_empresa_id'];
            $valorSector->ratio_id = $item['ratio_id'];
            $valorSector->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Valores de sector creados correctamente'
        ], 200);
    }

    public function update(Request $request)
    {
        $data = $request->all();

        foreach ($data as $item) {
            $validator = Validator::make($item, [
                'id' => 'required',
                'valor' => 'required|numeric',
                'sector_empresa_id' => 'required',
                'ratio_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->all()
                ], 400);
            }

            $valorSector = ValorSectorRatio::find($item['id']);
            if (!$valorSector) {
                return response()->json([
                    'status' => false,
                    'message' => 'ValorSectorRatio not found'
                ], 404);
            }

            $valorSector->valor = $item['valor'];
            $valorSector->sector_empresa_id = $item['sector_empresa_id'];
            $valorSector->ratio_id = $item['ratio_id'];
            $valorSector->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Valores de sector actualizados correctamente'
        ], 200);
    }

    public function destroy($id)
    {
        if ($id)
        {
            $valorSector = ValorSectorRatio::find($id);
            $valorSector->delete();
            return response()->json([
                'status'=> true,
                'message' => 'Valor de sector eliminado correctamente'
            ], 200);
        }
        else
        {
            return response()->json([
                'status'=> false,
                'message' => 'Valor de sector no encontrado'
            ], 400);
        }
    }
}
