<?php

namespace App\Http\Controllers;

use App\Models\Compteur;
use Illuminate\Http\Request;

class CompteurController extends Controller
{
    public function index(Request $request)
    {
        $query = Compteur::query();
        if ($request->filled('disponible')) {
            $query->where('attribue', false);
        }
        $compteurs = $query->orderBy('numero_serie')->paginate(10)->withQueryString();
        return view('compteurs.index', compact('compteurs'));
    }
    public function create()
    {
        return view('compteurs.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero_serie' => 'required|string|max:255|unique:compteurs,numero_serie',
            'ancien_index' => 'nullable|integer|min:0',
        ]);
        $validated['attribue'] = false;
        Compteur::create($validated);
        return redirect()->route('compteurs.index')
            ->with('success', 'Compteur ajouté avec succès.');
    }
    public function show(Compteur $compteur)
    {
        $compteur->load('abonnements.client', 'prelevements');
        return view('compteurs.show', compact('compteur'));
    }
    public function edit(Compteur $compteur)
    {
        return view('compteurs.edit', compact('compteur'));
    }
    public function update(Request $request, Compteur $compteur)
    {
        $validated = $request->validate([
            'numero_serie' => 'required|string|max:255|unique:compteurs,numero_serie,'.$compteur->id,
            'ancien_index' => 'nullable|integer|min:0',
            'attribue' => 'nullable|boolean',
        ]);
        $validated['attribue'] = $request->has('attribue');
        $compteur->update($validated);
        return redirect()->route('compteurs.index')
            ->with('success', 'Compteur modifié avec succès.');
    }
    public function destroy(Compteur $compteur)
    {
        $compteur->delete();
        return redirect()->route('compteurs.index')
            ->with('success', 'Compteur archivé/supprimé avec succès.');
    }
}