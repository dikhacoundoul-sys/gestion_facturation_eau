<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Compteurs') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <a href="{{ route('compteurs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Ajouter un compteur
                    </a>
                    <form method="GET" action="{{ route('compteurs.index') }}" class="flex gap-2 items-center">
                        <label class="flex items-center gap-1 text-sm">
                            <input type="checkbox" name="disponible" value="1" {{ request('disponible') ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            Compteurs disponibles uniquement
                        </label>
                    </form>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">N° Série</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ancien Index</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($compteurs as $compteur)
                            <tr>
                                <td class="px-4 py-2">{{ $compteur->numero_serie }}</td>
                                <td class="px-4 py-2">{{ $compteur->ancien_index }}</td>
                                <td class="px-4 py-2">
                                    @if ($compteur->attribue)
                                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">Attribué</span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Disponible</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('compteurs.show', $compteur) }}" class="text-blue-600 hover:underline">Voir</a>
                                    <a href="{{ route('compteurs.edit', $compteur) }}" class="text-yellow-600 hover:underline">Modifier</a>
                                   @if (Auth::user()->isAdmin())
                                    <form action="{{ route('compteurs.destroy', $compteur) }}" method="POST" onsubmit="return confirm('Supprimer ce compteur ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                                    </form>
                                        @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500">Aucun compteur trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $compteurs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>