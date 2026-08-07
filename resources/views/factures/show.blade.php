<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détail Facture #'.$facture->id) }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Détails de la facture</h3>
                <dl class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-gray-500">Client</dt>
                        <dd class="font-medium">{{ $facture->client->nom }} {{ $facture->client->prenom }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Compteur</dt>
                        <dd class="font-medium">{{ $facture->compteur->numero_serie }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Consommation</dt>
                        <dd class="font-medium">{{ $facture->consommation }} m³</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Montant total</dt>
                        <dd class="font-medium">{{ number_format($facture->montant, 0, ',', ' ') }} FCFA</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Montant payé</dt>
                        <dd class="font-medium text-green-600">{{ number_format($montantPaye, 0, ',', ' ') }} FCFA</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Solde restant</dt>
                        <dd class="font-medium {{ $solde > 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ number_format($solde, 0, ',', ' ') }} FCFA
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Historique des paiements</h3>
                @if ($facture->facturations->isEmpty())
                    <p class="text-gray-500">Aucun paiement enregistré pour cette facture.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200 mb-4">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mode de règlement</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($facture->facturations as $paiement)
                                <tr>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">{{ number_format($paiement->mensualite, 0, ',', ' ') }} FCFA</td>
                                    <td class="px-4 py-2">{{ $paiement->reglement ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if ($solde > 0)
                    <a href="{{ route('facturations.create', ['facture_id' => $facture->id]) }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Effectuer un paiement
                    </a>
                @else
                    <p class="text-green-600 font-medium">✓ Facture entièrement payée.</p>
                @endif
            </div>
            <a href="{{ route('factures.pdf', $facture) }}" class="inline-block bg-gray-700 text-blue px-4 py-2 rounded hover:bg-gray-800">
                Télécharger le PDF
            </a>
            <a href="{{ route('factures.index') }}" class="text-blue-600 hover:underline">&larr; Retour à la liste des factures</a>
        </div>
    </div>
</x-app-layout>