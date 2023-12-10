<?php

namespace App\Http\Controllers;
use App\Models\TipoEstadoFinanciero;
use Illuminate\Http\Request;

class TipoEstadoFinancieroController extends Controller
{
    public function index()
    {

        return  TipoEstadoFinanciero::all();
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

}
