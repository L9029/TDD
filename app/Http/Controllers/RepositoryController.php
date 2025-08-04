<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\RepositoryRequest;
use App\Models\Repository;

class RepositoryController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $repositories = auth()->user()->repositories;

        return view('repositories.index', [
            "repositories" => $repositories,
        ]);
    }

    public function create()
    {
        return view('repositories.create');
    }

    public function store(RepositoryRequest $request)
    {
        $request->user()->repositories()->create([
            'url' => $request->input('url'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route("repositories.index")->with('status', 'Repositorio creado exitosamente.');
    }

    public function show($id)
    {
        $repository = Repository::findOrFail($id);

        // Verifica que el usuario autenticado sea el propietario del repositorio
        $this->authorize('pass', $repository);

        return view('repositories.show', [
            'repository' => $repository,
        ]);
    }

    public function edit($id)
    {
        $repository = Repository::findOrFail($id);

        // Verifica que el usuario autenticado sea el propietario del repositorio
        $this->authorize('pass', $repository);

        return view('repositories.edit', [
            'repository' => $repository,
        ]);
    }

    public function update(RepositoryRequest $request, $id)
    {
        $repository = Repository::findOrFail($id);

        // Verifica que el usuario autenticado sea el propietario del repositorio
        $this->authorize('pass', $repository);

        $repository->update($request->all());

        return redirect()->route("repositories.edit", $repository->id)->with('status', 'Repositorio actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $repository = Repository::findOrFail($id);

        // Verifica que el usuario autenticado sea el propietario del repositorio
        $this->authorize('pass', $repository);

        $repository->delete();

        return redirect()->route("repositories.index")->with('status', 'Repositorio eliminado exitosamente.');
    }
}
