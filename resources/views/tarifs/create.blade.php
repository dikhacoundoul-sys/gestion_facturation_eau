<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un Tarif') }}
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
                <form action="{{ route('tarifs.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Catégorie / Collectivité</label>
                        <input type="text" name="categorie" value="{{ old('categorie') }}"
                               placeholder="Ex: Standard, Ménage, Administration..."
                               class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Utilise "Standard" comme catégorie par défaut pour les clients sans collectivité renseignée.</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Prix au m³ (FCFA)</label>
                        <input type="number" name="prix_m3" value="{{ old('prix_m3') }}" min="0" step="1"
                               class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Enregistrer
                        </button>
                        <a href="{{ route('tarifs.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>