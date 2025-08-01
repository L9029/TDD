<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Repositories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>URL</th>
                            <th>Fecha de Creación</th>
                            <th>Fecha de Actualización</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($repositories as $repository)
                            <tr>
                                <td>{{ $repository->id }}</td>
                                <td>{{ $repository->name }}</td>
                                <td>{{ $repository->url }}</td>
                                <td>{{ $repository->description }}</td>
                                <td>{{ $repository->created_at }}</td>
                                <td>{{ $repository->updated_at }}</td>
                                <td>
                                    <a href="{{ route('repositories.show', $repository->id) }}" class="text-blue-500 hover:underline">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No hay repositorios disponibles.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>