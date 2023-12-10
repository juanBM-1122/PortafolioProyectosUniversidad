<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ratio;
use App\Models\ValorSectorRatio;
use Illuminate\Support\Facades\Validator;

class RatioController extends Controller
{
    //
    public function index(Request $request)
    {
        $valorRatios = [];
        $ratiosPorSector = $this->recuperarValoresSectorRatio($request->input("sector_id"));
        $ratio = Ratio::all();
        if (count( $ratiosPorSector ) > 0)
        {
            $bandera = false;
            $valorRatios = $ratiosPorSector;
            foreach ($ratio as $ratioVal){
                foreach ($valorRatios as $valorRatio){
                    if ($valorRatio['nombre'] == $ratioVal['nombre']){
                        $bandera = true;
                        break;
                    }
                }
                if (!$bandera){
                    $valorRatios[] = ['nombre' => $ratioVal['nombre'], 'valor' => 0, 'ratio_id' => $ratioVal['id']];
                    $bandera = false;
                }
            }
        }
        else
        {
            $valorRatios = Ratio::all();
            foreach ($valorRatios as $ratio) {
                $ratio["valor"] = 0;
            }
        }
        
        return response()->json([
            'status' => true,
            'ratios' => $valorRatios,
        ]);
    }

    public function recuperarValoresSectorRatio($idSector){
        $valoresRatioSector = ValorSectorRatio::join('ratios','ratio_id','=','ratios.id')
        ->where('sector_empresa_id','=',$idSector)
        ->select('valor_sector_ratios.id', 'valor_sector_ratios.ratio_id', 'valor_sector_ratios.valor', 'valor_sector_ratios.sector_empresa_id', 'ratios.nombre')
        ->get();
        return $valoresRatioSector;
    }

    public function guardarEditarValorRatio(Request $request){
        $validator = Validator::make($request->all(), [
            'sector_id' => 'required',
            //'ratio_id' => 'required',
            'valoresSectorRatio' => 'required',
        ]);

        if ($validator->fails()) {	
            return response()->json([
                'status'=> false,
                'message'=> $validator->errors()->all(),
            ]);
        }

        $valoresSectorRatio = $validator->validated();

        foreach($valoresSectorRatio['valoresSectorRatio'] as $valorSectorRatio){
            if (isset($valorSectorRatio['id'])){
                $valorSector = ValorSectorRatio::findOrFail($valorSectorRatio['id']);
                $valorSector->valor = $valorSectorRatio['valor'];
                $valorSector->save();
            }
            else{
                $valorSector = new ValorSectorRatio();
                $valorSector->valor = $valorSectorRatio['valor'];
                $valorSector->sector_empresa_id = $valoresSectorRatio['sector_id'];
                $valorSector->ratio_id = $valorSectorRatio['ratio_id'];
                $valorSector->save();
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Valores de sector creados correctamente',
            //'valores' => $valoresSectorRatio['valoresSectorRatio'][0]['valor'],
        ], 200);
    }
}
