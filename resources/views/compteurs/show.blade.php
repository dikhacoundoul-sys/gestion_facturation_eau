<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fiche Compteur') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Informations du compteur</h3>
                <dl class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-gray-500">N° Série</dt>
                        <dd class="font-medium">{{ $compteur->numero_serie }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Ancien Index</dt>
                        <dd class="font-medium">{{ $compteur->ancien_index }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Statut</dt>
                        <dd class="font-medium">
                            @if ($compteur->attribue)
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">Attribué</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Disponible</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Historique des abonnements</h3>
                @if ($compteur->abonnements->isEmpty())
                    <p class="text-gray-500">Aucun abonné pour ce compteur.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date d'abonnement</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($compteur->abonnements as $abonnement)
                                <tr>
                                    <td class="px-4 py-2">{{ $abonnement->client->nom }} {{ $abonnement->client->prenom }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($abonnement->date_abonnement)->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Historique des relevés</h3>
                @if ($compteur->prelevements->isEmpty())
                    <p class="text-gray-500">Aucun relevé pour ce compteur.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ancien Index</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nouvel Index</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Consommation</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($compteur->prelevements as $prelevement)
                                <tr>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($prelevement->date_prelevement)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">{{ $prelevement->ancien_index }}</td>
                                    <td class="px-4 py-2">{{ $prelevement->new_index }}</td>
                                    <td class="px-4 py-2">{{ $prelevement->consommation }} m³</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <a href="{{ route('compteurs.index') }}" class="text-blue-600 hover:underline">&larr; Retour à la liste</a>
        </div>
    </div>
</x-app-layout>