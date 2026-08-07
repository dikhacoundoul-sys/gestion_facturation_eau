<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Cartes de statistiques -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <p class="text-sm text-gray-500">Total Abonnés</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalClients }}</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <p class="text-sm text-gray-500">Total Compteurs</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalCompteurs }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $compteursAttribues }} attribués · {{ $compteursDisponibles }} disponibles
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <p class="text-sm text-gray-500">Total Facturé</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalFacture, 0, ',', ' ') }}</p>
                    <p class="text-xs text-gray-400 mt-1">FCFA</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <p class="text-sm text-gray-500">Montant Impayé</p>
                    <p class="text-3xl font-bold {{ $totalImpaye > 0 ? 'text-red-600' : 'text-green-600' }} mt-1">
                        {{ number_format($totalImpaye, 0, ',', ' ') }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">{{ $facturesImpayees }} facture(s) non soldée(s)</p>
                </div>

            </div>

            <!-- Répartition compteurs -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <p class="text-sm text-gray-500 mb-2">Compteurs disponibles</p>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-green-500 h-3 rounded-full"
                             style="width: {{ $totalCompteurs > 0 ? ($compteursDisponibles / $totalCompteurs * 100) : 0 }}%">
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ $compteursDisponibles }} / {{ $totalCompteurs }}</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <p class="text-sm text-gray-500 mb-2">Montant recouvré</p>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-500 h-3 rounded-full"
                             style="width: {{ $totalFacture > 0 ? ($totalPaye / $totalFacture * 100) : 0 }}%">
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ number_format($totalPaye, 0, ',', ' ') }} / {{ number_format($totalFacture, 0, ',', ' ') }} FCFA
                    </p>
                </div>
            </div>

            <!-- Dernières factures -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Dernières factures</h3>
                    <a href="{{ route('factures.index') }}" class="text-sm text-blue-600 hover:underline">Voir tout</a>
                </div>

                @if ($dernieresFactures->isEmpty())
                    <p class="text-gray-500">Aucune facture pour le moment.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">N°</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Consommation</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($dernieresFactures as $facture)
                                <tr>
                                    <td class="px-4 py-2">{{ $facture->id }}</td>
                                    <td class="px-4 py-2">{{ $facture->client->nom }} {{ $facture->client->prenom }}</td>
                                    <td class="px-4 py-2">{{ $facture->consommation }} m³</td>
                                    <td class="px-4 py-2">{{ number_format($facture->montant, 0, ',', ' ') }} FCFA</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('factures.show', $facture) }}" class="text-blue-600 hover:underline">Voir</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Actions rapides -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Actions rapides</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('clients.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Nouvel abonné
                    </a>
                    <a href="{{ route('compteurs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Nouveau compteur
                    </a>
                    <a href="{{ route('prelevements.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Nouveau relevé
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>