<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Effectuer un Paiement') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-4 p-4 bg-gray-50 rounded">
                    <p class="text-sm text-gray-600">Facture #{{ $facture->id }} — {{ $facture->client->nom }} {{ $facture->client->prenom }}</p>
                    <p class="text-sm text-gray-600">Compteur : {{ $facture->compteur->numero_serie }}</p>
                    <p class="font-medium mt-2">Solde restant : <span class="text-red-600">{{ number_format($solde, 0, ',', ' ') }} FCFA</span></p>
                </div>
                <form action="{{ route('facturations.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="facture_id" value="{{ $facture->id }}">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Date de paiement</label>
                        <input type="date" name="date_paiement" value="{{ old('date_paiement', date('Y-m-d')) }}"
                               class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Montant à payer (max {{ number_format($solde, 0, ',', ' ') }} FCFA)</label>
                        <input type="number" name="mensualite" value="{{ old('mensualite', $solde) }}" min="1" max="{{ $solde }}" step="1"
                               class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Mode de règlement</label>
                        <select name="reglement" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                            <option value="Espèces">Espèces</option>
                            <option value="Mobile Money">Mobile Money</option>
                            <option value="Chèque">Chèque</option>
                            <option value="Virement">Virement</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Enregistrer le paiement
                        </button>
                        <a href="{{ route('factures.show', $facture) }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>