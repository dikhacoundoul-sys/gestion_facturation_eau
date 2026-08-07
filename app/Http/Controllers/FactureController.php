<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
    public function index()
    {
        $factures = Facture::with('client', 'compteur')
            ->latest()
            ->paginate(10);

        return view('factures.index', compact('factures'));
    }
    public function show(Facture $facture)
    {
        $facture->load('client', 'compteur', 'facturations');
        $montantPaye = $facture->facturations->sum('mensualite');
        $solde = $facture->montant - $montantPaye;
        return view('factures.show', compact('facture', 'montantPaye', 'solde'));
    }
    public function pdf(Facture $facture)
    {
        $facture->load('client', 'compteur', 'facturations');
        $montantPaye = $facture->facturations->sum('mensualite');
        $solde = $facture->montant - $montantPaye;
        $pdf = Pdf::loadView('factures.pdf', compact('facture', 'montantPaye', 'solde'));
        return $pdf->download('facture_'.$facture->id.'.pdf');
    }
}