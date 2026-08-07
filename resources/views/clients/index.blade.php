<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Abonnés') }}
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
                    <a href="{{ route('clients.create') }}" class="btn btn-primary bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Ajouter un abonné
                    </a>
                    <form method="GET" action="{{ route('clients.index') }}" class="flex gap-2">
                        <input type="text" name="recherche" value="{{ request('recherche') }}"
                               placeholder="Rechercher un abonné..."
                               class="border-gray-300 rounded shadow-sm">

                        <label class="flex items-center gap-1 text-sm">
                            <input type="checkbox" name="tri_categorie" value="1" {{ request('tri_categorie') ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            Trier par collectivité
                        </label>
                        <button type="submit" class="bg-gray-200 px-3 py-1 rounded">Filtrer</button>
                    </form>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Prénom</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Adresse</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Téléphone</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Collectivité</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($clients as $client)
                            <tr>
                                <td class="px-4 py-2">{{ $client->nom }}</td>
                                <td class="px-4 py-2">{{ $client->prenom }}</td>
                                <td class="px-4 py-2">{{ $client->adresse }}</td>
                                <td class="px-4 py-2">{{ $client->telephone }}</td>
                                <td class="px-4 py-2">{{ $client->categorie ?? '-' }}</td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:underline">Voir</a>
                                    <a href="{{ route('clients.edit', $client) }}" class="text-yellow-600 hover:underline">Modifier</a>
                                    @if (Auth::user()->isAdmin())
                                    <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Supprimer cet abonné ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                                    </form>
                                      @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-500">Aucun abonné trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $clients->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>