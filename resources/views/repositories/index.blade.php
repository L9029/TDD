<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Repositories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p class="text-right mb-4">
                <a href="{{ route('repositories.create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded text-sm hover:bg-blue-600">
                    Crear Repositorio
                </a>
            </p>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <table>
                    <thead>
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">URL</th>
                            <th class="px-4 py-2">Descripción</th>
                            <th class="px-4 py-2">Fecha de Creación</th>
                            <th class="px-4 py-2">Fecha de Actualización</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($repositories as $repository)
                            <tr class="text-center {{ $loop->even ? 'bg-gray-100 hover:bg-gray-200' : 'bg-gray-200 hover:bg-gray-300' }}">
                                <td class="px-4 py-2">{{ $repository->id }}</td>
                                <td class="px-4 py-2">{{ $repository->url }}</td>
                                <td class="px-4 py-2">{{ $repository->description }}</td>
                                <td class="px-4 py-2">{{ $repository->created_at->format('d-m-Y') }}</td>
                                <td class="px-4 py-2">{{ $repository->updated_at->format('d-m-Y') }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('repositories.show', $repository->id) }}" class="px-4 rounded-md bg-blue-500 text-white hover:bg-blue-600">
                                        Ver
                                    </a>
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('repositories.edit', $repository->id) }}" class="px-4 rounded-md bg-blue-500 text-white hover:bg-blue-600">
                                        Editar
                                    </a>
                                </td>
                                <td class="px-4 py-2">
                                    <form action="{{ route('repositories.destroy', $repository->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este repositorio?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="px-4 rounded-md bg-red-500 text-white hover:bg-red-600">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No hay repositorios disponibles.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>