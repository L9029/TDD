<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repository;

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
        $repository = Repository::findOrFail($id);
        $repository->update($request->all());

        return redirect()->route("repositories.edit", $repository->id)->with('status', 'Repositorio actualizado exitosamente.');
    }

    public function destroy($id)
    {
        // Lógica para eliminar un repositorio
    }
}
