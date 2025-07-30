<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    public function index()
    {
        // Lógica para mostrar la lista de repositorios
    }

    public function create()
    {
        // Lógica para mostrar el formulario de creación de repositorio
    }

    public function store(Request $request)
    {
        $request->user()->repositories()->create([
            'url' => $request->input('url'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route("repositories.index")->with('status', 'Repositorio creado exitosamente.');
    }

    public function show($id)
    {
        // Lógica para mostrar un repositorio específico
    }

    public function edit($id)
    {
        // Lógica para mostrar el formulario de edición de un repositorio
    }

    public function update(Request $request, $id)
    {
        // Lógica para actualizar un repositorio existente
    }

    public function destroy($id)
    {
        // Lógica para eliminar un repositorio
    }
}
