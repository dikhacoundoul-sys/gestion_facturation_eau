<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fiche Abonné / Compteur') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Informations personnelles</h3>
                <dl class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-gray-500">Nom</dt>
                        <dd class="font-medium">{{ $client->nom }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Prénom</dt>
                        <dd class="font-medium">{{ $client->prenom }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Adresse</dt>
                        <dd class="font-medium">{{ $client->adresse }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Téléphone</dt>
                        <dd class="font-medium">{{ $client->telephone }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Collectivité</dt>
                        <dd class="font-medium">{{ $client->categorie ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Compteurs abonnés</h3>
                    <a href="{{ route('abonnements.create', ['client_id' => $client->id]) }}" class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                        + Assigner un compteur
                    </a>
                </div>
                @if ($client->abonnements->isEmpty())
                    <p class="text-gray-500">Aucun compteur associé à cet abonné.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">N° Compteur</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">N° Série</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date d'abonnement</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($client->abonnements as $abonnement)
                                <tr>
                                    <td class="px-4 py-2">{{ $abonnement->compteur->id }}</td>
                                    <td class="px-4 py-2">{{ $abonnement->compteur->numero_serie }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($abonnement->date_abonnement)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">
                                        <form action="{{ route('abonnements.destroy', $abonnement) }}" method="POST" onsubmit="return confirm('Retirer ce compteur de l\'abonné ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm">Retirer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Factures</h3>
                @if ($client->factures->isEmpty())
                    <p class="text-gray-500">Aucune facture pour cet abonné.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">N° Facture</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Consommation</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($client->factures as $facture)
                                <tr>
                                    <td class="px-4 py-2">{{ $facture->id }}</td>
                                    <td class="px-4 py-2">{{ $facture->consommation }} m³</td>
                                    <td class="px-4 py-2">{{ number_format($facture->montant, 0, ',', ' ') }} FCFA</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <a href="{{ route('clients.index') }}" class="text-blue-600 hover:underline">&larr; Retour à la liste</a>
        </div>
    </div>
</x-app-layout>