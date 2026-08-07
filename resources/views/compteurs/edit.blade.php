<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le Compteur') }}
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
                <form action="{{ route('compteurs.update', $compteur) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">N° Série</label>
                        <input type="text" name="numero_serie" value="{{ old('numero_serie', $compteur->numero_serie) }}"
                               class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Ancien Index</label>
                        <input type="number" name="ancien_index" value="{{ old('ancien_index', $compteur->ancien_index) }}" min="0"
                               class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="attribue" value="1" {{ $compteur->attribue ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700">Compteur attribué</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Décoche cette case pour rendre le compteur disponible (archivage/transfert).</p>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Mettre à jour
                        </button>
                        <a href="{{ route('compteurs.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>