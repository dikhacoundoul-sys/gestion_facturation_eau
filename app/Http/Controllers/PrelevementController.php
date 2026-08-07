<?php

namespace App\Http\Controllers;

use App\Models\Compteur;
use App\Models\Facture;
use App\Models\Prelevement;
use Illuminate\Http\Request;

class PrelevementController extends Controller
{
    public function create(Request $request)
    {
        $compteurs = Compteur::where('attribue', true)->orderBy('numero_serie')->get();
        $compteurSelectionne = $request->query('compteur_id');

        return view('prelevements.create', compact('compteurs', 'compteurSelectionne'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'compteur_id' => 'required|exists:compteurs,id',
            'date_prelevement' => 'required|date',
            'new_index' => 'required|integer|min:0',
        ]);
        $compteur = Compteur::findOrFail($validated['compteur_id']);
        if ($validated['new_index'] < $compteur->ancien_index) {
            return back()->withErrors(['new_index' => 'Le nouvel index doit être supérieur ou égal à l\'ancien index ('.$compteur->ancien_index.').'])->withInput();
        }
        $prelevement = Prelevement::create([
            'compteur_id' => $compteur->id,
            'date_prelevement' => $validated['date_prelevement'],
            'ancien_index' => $compteur->ancien_index,
            'new_index' => $validated['new_index'],
        ]);
        $consommation = $validated['new_index'] - $compteur->ancien_index;

        $abonnement = $compteur->abonnements()->latest('date_abonnement')->first();
        if (! $abonnement) {
            return back()->withErrors(['compteur_id' => 'Ce compteur n\'est associé à aucun abonné.'])->withInput();
        }
        $client = $abonnement->client;
        $tarif = \App\Models\Tarif::where('categorie', $client->categorie)->first()
            ?? \App\Models\Tarif::where('categorie', 'Standard')->first();

        if (! $tarif) {
            return back()->withErrors(['compteur_id' => 'Aucun tarif défini pour la catégorie "'.($client->categorie ?? 'Standard').'". Ajoute d\'abord un tarif.'])->withInput();
        }

        $montant = $consommation * $tarif->prix_m3;
        $facture = Facture::create([
            'client_id' => $abonnement->client_id,
            'compteur_id' => $compteur->id,
            'solde_anterieur' => 0,
            'consommation' => $consommation,
            'montant' => $montant,
        ]);
        $compteur->update(['ancien_index' => $validated['new_index']]);
        return redirect()->route('factures.show', $facture)
            ->with('success', 'Relevé enregistré et facture générée avec succès.');
    }
}