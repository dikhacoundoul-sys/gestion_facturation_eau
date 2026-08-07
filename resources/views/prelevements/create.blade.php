<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouveau Relevé de Compteur') }}
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
                        Aucun compteur attribué actuellement. Assignez d'abord un compteur à un abonné.
                    </div>
                @endif

                <form action="{{ route('prelevements.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Compteur</label>
                        <select name="compteur_id" id="compteur_id" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                            <option value="">-- Choisir un compteur --</option>
                            @foreach ($compteurs as $compteur)
                                <option value="{{ $compteur->id }}"
                                    data-ancien-index="{{ $compteur->ancien_index }}"
                                    {{ old('compteur_id', $compteurSelectionne) == $compteur->id ? 'selected' : '' }}>
                                    {{ $compteur->numero_serie }} (Ancien index : {{ $compteur->ancien_index }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Date du relevé</label>
                        <input type="date" name="date_prelevement" value="{{ old('date_prelevement', date('Y-m-d')) }}"
                               class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nouvel Index</label>
                        <input type="number" name="new_index" value="{{ old('new_index') }}" min="0"
                               class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                        <p id="ancien-index-info" class="text-xs text-gray-500 mt-1"></p>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Enregistrer et générer la facture
                        </button>
                        <a href="{{ route('clients.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                            Annuler
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        const select = document.getElementById('compteur_id');
        const info = document.getElementById('ancien-index-info');
        function updateInfo() {
            const selected = select.options[select.selectedIndex];
            const ancienIndex = selected.getAttribute('data-ancien-index');
            info.textContent = ancienIndex !== null ? `L'index doit être supérieur ou égal à ${ancienIndex}.` : '';
        }
        select.addEventListener('change', updateInfo);
        updateInfo();
    </script>
</x-app-layout>