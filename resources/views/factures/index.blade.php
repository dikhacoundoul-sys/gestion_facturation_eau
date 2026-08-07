<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion de la Facturation') }}
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
                    <a href="{{ route('prelevements.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Nouveau relevé / facture
                    </a>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">N° Facture</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Compteur</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Consommation</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($factures as $facture)
                            <tr>
                                <td class="px-4 py-2">{{ $facture->id }}</td>
                                <td class="px-4 py-2">{{ $facture->client->nom }} {{ $facture->client->prenom }}</td>
                                <td class="px-4 py-2">{{ $facture->compteur->numero_serie }}</td>
                                <td class="px-4 py-2">{{ $facture->consommation }} m³</td>
                                <td class="px-4 py-2">{{ number_format($facture->montant, 0, ',', ' ') }} FCFA</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('factures.show', $facture) }}" class="text-blue-600 hover:underline">Voir / Payer</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-500">Aucune facture générée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $factures->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>