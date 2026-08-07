<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();
        // Tri par catégorie/collectivité (croissant)
        if ($request->filled('tri_categorie')) {
            $query->orderBy('categorie', 'asc');
        } else {
            $query->orderBy('nom', 'asc');
        }
        // Recherche simple (optionnel, pratique en plus du tri)
        if ($request->filled('recherche')) {
            $query->where(function ($q) use ($request) {
                $q->where('nom', 'like', '%'.$request->recherche.'%')
                  ->orWhere('prenom', 'like', '%'.$request->recherche.'%');
            });
        }
        $clients = $query->paginate(10)->withQueryString();

        return view('clients.index', compact('clients'));
    }
    public function create()
    {
        return view('clients.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'categorie' => 'nullable|string|max:255',
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Abonné créé avec succès.');
    }

    public function show(Client $client)
    {
        $client->load('abonnements.compteur', 'factures');

        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'categorie' => 'nullable|string|max:255',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Abonné modifié avec succès.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Abonné supprimé avec succès.');
    }
}