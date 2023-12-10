<?php

namespace App\Http\Controllers;

use App\Models\CuentaEmpresa;
use App\Models\Empresa;
use Illuminate\Http\Request;

class CuentaEmpresaController extends Controller
{

    public function create()
    {
    }

    // Almacenar un nuevo recurso en la base de datos
    public function store2(Request $request)
    { // Validar los datos recibidos del formulario
        $data = $request->validate([
            'empresa_id' => 'required',
            'cuenta_id' => 'required',
            'tipo_estado_financiero_id' => 'required',
            'nombreCuenta' => 'required',
        ]);
        // Obtén el empresa_id que recibiste de la solicitud GET
        $empresa_id = $request->empresa_id;
        // Crear una nueva instancia de CuentaEmpresa
        $cuentaEmpresa = new CuentaEmpresa();

        // Asignar los valores a los atributos de la nueva CuentaEmpresa
        $cuentaEmpresa->empresa_id = $empresa_id;
        $cuentaEmpresa->cuenta_id = $data['cuenta_id'];
        $cuentaEmpresa->tipo_estado_financiero_id = $data['tipo_estado_financiero_id'];
        $cuentaEmpresa->nombreCuenta = $data['nombreCuenta'];

        // Guardar la nueva CuentaEmpresa en la base de datos
        $cuentaEmpresa->save();

        // Devolver una respuesta
        return response()->json(['message' => 'CuentaEmpresa creada con éxito'], 201);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'nombreEmpresa' => 'required',
            'sectorEmpresa' => 'required',
            'cuentasActivos' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $nombre_empresa = $request->nombreEmpresa;
        $sector_empresa = $request->sectorEmpresa;

        $empresa = Empresa::create([
            "sector_empresa_id" => $sector_empresa,
            "nombre" => $nombre_empresa
        ]);


        $activos = $request->cuentasActivos;
        $pasivos = $request->cuentasPasivos;
        $patrimonio = $request->cuentasPatrimonio;
        $ingresos = $request->cuentasIngresos;
        $gastos = $request->cuentasGastos;
        $costos = $request->cuentasCostos;

        try {
            foreach ($activos as $cuenta) {
                CuentaEmpresa::create([
                    'empresa_id' => $empresa->id,
                    'cuenta_id' => $cuenta['cuenta_id'],
                    'tipo_estado_financiero_id' => $cuenta['tipo_estado_financiero_id'],
                    'nombreCuenta' => $cuenta['nombre']
                ]);
            }
            foreach ($pasivos as $cuenta) {
                CuentaEmpresa::create([
                    'empresa_id' => $empresa->id,
                    'cuenta_id' => $cuenta['cuenta_id'],
                    'tipo_estado_financiero_id' => $cuenta['tipo_estado_financiero_id'],
                    'nombreCuenta' => $cuenta['nombre']
                ]);
            }
            foreach ($patrimonio as $cuenta) {
                CuentaEmpresa::create([
                    'empresa_id' => $empresa->id,
                    'cuenta_id' => $cuenta['cuenta_id'],
                    'tipo_estado_financiero_id' => $cuenta['tipo_estado_financiero_id'],
                    'nombreCuenta' => $cuenta['nombre']
                ]);
            }
            foreach ($ingresos as $cuenta) {
                CuentaEmpresa::create([
                    'empresa_id' => $empresa->id,
                    'cuenta_id' => $cuenta['cuenta_id'],
                    'tipo_estado_financiero_id' => $cuenta['tipo_estado_financiero_id'],
                    'nombreCuenta' => $cuenta['nombre']
                ]);
            }
            foreach ($gastos as $cuenta) {
                CuentaEmpresa::create([
                    'empresa_id' => $empresa->id,
                    'cuenta_id' => $cuenta['cuenta_id'],
                    'tipo_estado_financiero_id' => $cuenta['tipo_estado_financiero_id'],
                    'nombreCuenta' => $cuenta['nombre']
                ]);
            }
            foreach ($costos as $cuenta) {
                CuentaEmpresa::create([
                    'empresa_id' => $empresa->id,
                    'cuenta_id' => $cuenta['cuenta_id'],
                    'tipo_estado_financiero_id' => $cuenta['tipo_estado_financiero_id'],
                    'nombreCuenta' => $cuenta['nombre']
                ]);
            }


            return response()->json([
                'message' => 'Cuentas agregadas correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'empresa_id' => $empresa
            ], 400);
        }

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
    public function getCuentasEmpresa(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'empresa' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first(),
            ], 400);
        }

        $cuentas = CuentaEmpresa::where('empresa_id', $request->empresa)->get();

        if (isset($cuentas)) {
            return response()->json([
                'status' => true,
                'cuentas' => $cuentas
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'mensaje' => 'Error al obtener las cuentas'
            ], 400);
        }
    }
}
