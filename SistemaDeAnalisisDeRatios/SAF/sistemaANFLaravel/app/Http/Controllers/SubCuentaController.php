<?php

namespace App\Http\Controllers;

use App\Models\ValorCuenta;
use Illuminate\Http\Request;
use App\Models\SubCuenta;
class SubCuentaController extends Controller
{
    public function index()
    {

        return  SubCuenta::all();
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


    public function getTotalSubCuenta($year,$empresa_id,$sub_cuenta){
        
        $total_sub_cuenta = ValorCuenta::join('cuenta_empresas', 'valor_cuentas.cuenta_empresa_id', '=', 'cuenta_empresas.id')
        ->join('cuentas', 'cuenta_empresas.cuenta_id', '=', 'cuentas.id')
        ->join('sub_cuentas', 'cuentas.sub_cuenta_id', '=', 'sub_cuentas.id')
        ->join('empresas', 'cuenta_empresas.empresa_id', '=', 'empresas.id')
        ->where('sub_cuentas.nombre', $sub_cuenta)
        ->where('valor_cuentas.year', $year)
        ->where('empresas.id', $empresa_id)
        ->sum('valor_cuentas.valorCuenta');
        //->value(\DB::raw('COALESCE(SUM(valor_cuentas.valorCuenta), 0)'));

        /*if($total_sub_cuenta == null){
            return 0;
        }*/
        
        return $total_sub_cuenta;
    }

}
