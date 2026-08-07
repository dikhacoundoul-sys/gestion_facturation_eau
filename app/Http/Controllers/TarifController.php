<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index()
    {
        $tarifs = Tarif::orderBy('categorie')->get();

        return view('tarifs.index', compact('tarifs'));
    }

    public function create()
    {
        return view('tarifs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categorie' => 'required|string|max:255|unique:tarifs,categorie',
            'prix_m3' => 'required|numeric|min:0',
        ]);

        Tarif::create($validated);

        return redirect()->route('tarifs.index')
            ->with('success', 'Tarif ajouté avec succès.');
    }

    public function edit(Tarif $tarif)
    {
        return view('tarifs.edit', compact('tarif'));
    }

    public function update(Request $request, Tarif $tarif)
    {
        $validated = $request->validate([
            'categorie' => 'required|string|max:255|unique:tarifs,categorie,'.$tarif->id,
            'prix_m3' => 'required|numeric|min:0',
        ]);

        $tarif->update($validated);
        return redirect()->route('tarifs.index')
            ->with('success', 'Tarif modifié avec succès.');
    }
    public function destroy(Tarif $tarif)
    {
        $tarif->delete();
        return redirect()->route('tarifs.index')
            ->with('success', 'Tarif supprimé avec succès.');
    }
}