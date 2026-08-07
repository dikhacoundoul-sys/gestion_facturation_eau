<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Client;
use App\Models\Compteur;
use Illuminate\Http\Request;

class AbonnementController extends Controller
{
    public function create(Request $request)
    {
        $clients = Client::orderBy('nom')->get();
        $compteurs = Compteur::where('attribue', false)->orderBy('numero_serie')->get();
        $clientSelectionne = $request->query('client_id');
        return view('abonnements.create', compact('clients', 'compteurs', 'clientSelectionne'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'compteur_id' => 'required|exists:compteurs,id',
            'date_abonnement' => 'required|date',
        ]);
        $compteur = Compteur::findOrFail($validated['compteur_id']);
        if ($compteur->attribue) {
            return back()->withErrors(['compteur_id' => 'Ce compteur est déjà attribué à un abonné.'])->withInput();
        }
        Abonnement::create($validated);
        $compteur->update(['attribue' => true]);
        return redirect()->route('clients.show', $validated['client_id'])
            ->with('success', 'Compteur assigné à l\'abonné avec succès.');
    }
    public function destroy(Abonnement $abonnement)
    {
        $compteur = $abonnement->compteur;
        $clientId = $abonnement->client_id;
        $abonnement->delete();
        $compteur->update(['attribue' => false]);
        return redirect()->route('clients.show', $clientId)
            ->with('success', 'Abonnement supprimé, compteur libéré.');
    }
}