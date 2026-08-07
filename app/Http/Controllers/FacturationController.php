<?php

namespace App\Http\Controllers;

use App\Models\Facturation;
use App\Models\Facture;
use Illuminate\Http\Request;

class FacturationController extends Controller
{
    public function create(Request $request)
    {
        $facture = Facture::with('client', 'compteur', 'facturations')->findOrFail($request->query('facture_id'));
        $montantPaye = $facture->facturations->sum('mensualite');
        $solde = $facture->montant - $montantPaye;
        if ($solde <= 0) {
            return redirect()->route('factures.show', $facture)
                ->with('success', 'Cette facture est déjà entièrement payée.');
        }
        return view('facturations.create', compact('facture', 'solde'));
    }
    public function store(Request $request)
    {
        $facture = Facture::with('facturations')->findOrFail($request->facture_id);
        $montantPaye = $facture->facturations->sum('mensualite');
        $solde = $facture->montant - $montantPaye;
        $validated = $request->validate([
            'facture_id' => 'required|exists:factures,id',
            'date_paiement' => 'required|date',
            'mensualite' => 'required|numeric|min:1|max:'.$solde,
            'reglement' => 'nullable|string|max:255',
        ]);
        Facturation::create([
            'facture_id' => $facture->id,
            'client_id' => $facture->client_id,
            'compteur_id' => $facture->compteur_id,
            'date_paiement' => $validated['date_paiement'],
            'mensualite' => $validated['mensualite'],
            'reglement' => $validated['reglement'],
        ]);
        return redirect()->route('factures.show', $facture)
            ->with('success', 'Paiement enregistré avec succès.');
    }
}