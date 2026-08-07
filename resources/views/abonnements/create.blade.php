<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assigner un Compteur à un Abonné') }}
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
                @if ($compteurs->isEmpty())
                    <div class="mb-4 p-4 bg-yellow-100 text-yellow-700 rounded">
                        Aucun compteur disponible actuellement. Ajoutez d'abord un nouveau compteur.
                    </div>
                @endif
                <form action="{{ route('abonnements.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Abonné (Client)</label>
                        <select name="client_id" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                            <option value="">-- Choisir un client --</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id', $clientSelectionne) == $client->id ? 'selected' : '' }}>
                                    {{ $client->nom }} {{ $client->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Compteur disponible</label>
                        <select name="compteur_id" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                            <option value="">-- Choisir un compteur --</option>
                            @foreach ($compteurs as $compteur)
                                <option value="{{ $compteur->id }}" {{ old('compteur_id') == $compteur->id ? 'selected' : '' }}>
                                    {{ $compteur->numero_serie }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Date d'abonnement</label>
                        <input type="date" name="date_abonnement" value="{{ old('date_abonnement', date('Y-m-d')) }}"
                               class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Assigner
                        </button>
                        <a href="{{ route('clients.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                            Annuler
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>