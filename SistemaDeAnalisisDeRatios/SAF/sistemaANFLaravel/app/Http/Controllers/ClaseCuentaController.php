<?php

namespace App\Http\Controllers;
use App\Models\ClaseCuenta;
use App\Models\ValorCuenta;
use Illuminate\Http\Request;

class ClaseCuentaController extends Controller
{
    public function index()
    {

        return  ClaseCuenta::all();
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

    public function getTotalClaseCuenta($year,$empresa_id,$clase_cuenta){
        $totalClaseCuenta = ValorCuenta::join('cuenta_empresas', 'valor_cuentas.cuenta_empresa_id', '=', 'cuenta_empresas.id')
            ->join('cuentas', 'cuenta_empresas.cuenta_id', '=', 'cuentas.id')
            ->join('sub_cuentas', 'cuentas.sub_cuenta_id', '=', 'sub_cuentas.id')
            ->join('clase_cuentas', 'sub_cuentas.clase_cuenta_id', '=', 'clase_cuentas.id')
            ->where('clase_cuentas.nombre', $clase_cuenta)
            ->where('valor_cuentas.year', $year)
            ->where('cuenta_empresas.empresa_id', $empresa_id)
            ->sum('valor_cuentas.valorCuenta');

        return $totalClaseCuenta;
    }
}
