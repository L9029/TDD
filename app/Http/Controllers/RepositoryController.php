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
        // Validación de los datos del formulario
        $request->validate([
            'url' => 'required|url',
            'description' => 'required|string|max:255',
        ]);

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
        // Validación de los datos del formulario
        $request->validate([
            'url' => 'required|url',
            'description' => 'required|string|max:255',
        ]);

        $repository = Repository::findOrFail($id);

        // Verifica que el usuario autenticado sea el propietario del repositorio
        if ($repository->user_id !== $request->user()->id) {
            abort(403, 'No tienes permiso para editar este repositorio.');
        }

        $repository->update($request->all());

        return redirect()->route("repositories.edit", $repository->id)->with('status', 'Repositorio actualizado exitosamente.');
    }

    public function destroy(Request $request, $id)
    {
        $repository = Repository::findOrFail($id);

        // Verifica que el usuario autenticado sea el propietario del repositorio
        if ($repository->user_id !== $request->user()->id) {
            abort(403, 'No tienes permiso para editar este repositorio.');
        }

        $repository->delete();

        return redirect()->route("repositories.index")->with('status', 'Repositorio eliminado exitosamente.');
    }
}
