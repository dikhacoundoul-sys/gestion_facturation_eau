<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Tarifs') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-sm text-gray-500">Prix appliqué au m³ selon la catégorie/collectivité du client.</p>
                    <a href="{{ route('tarifs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Ajouter un tarif
                    </a>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Catégorie / Collectivité</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Prix / m³</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($tarifs as $tarif)
                            <tr>
                                <td class="px-4 py-2">{{ $tarif->categorie }}</td>
                                <td class="px-4 py-2">{{ number_format($tarif->prix_m3, 0, ',', ' ') }} FCFA</td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('tarifs.edit', $tarif) }}" class="text-yellow-600 hover:underline">Modifier</a>
                                    <form action="{{ route('tarifs.destroy', $tarif) }}" method="POST" onsubmit="return confirm('Supprimer ce tarif ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500">
                                    Aucun tarif défini. Pense à créer un tarif "Standard" pour les clients sans catégorie.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>