<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompteurController;
use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\PrelevementController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\FacturationController;
use App\Http\Controllers\TarifController;
use App\Models\Client;
use App\Models\Compteur;
use App\Models\Facture;
use App\Models\Facturation;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalClients = Client::count();
    $totalCompteurs = Compteur::count();
    $compteursDisponibles = Compteur::where('attribue', false)->count();
    $compteursAttribues = Compteur::where('attribue', true)->count();

    $totalFacture = Facture::sum('montant');
    $totalPaye = Facturation::sum('mensualite');
    $totalImpaye = $totalFacture - $totalPaye;

    $facturesImpayees = Facture::withSum('facturations', 'mensualite')
        ->get()
        ->filter(fn ($f) => ($f->facturations_sum_mensualite ?? 0) < $f->montant)
        ->count();

    $dernieresFactures = Facture::with('client', 'compteur')->latest()->take(5)->get();

    return view('dashboard', compact(
        'totalClients',
        'totalCompteurs',
        'compteursDisponibles',
        'compteursAttribues',
        'totalFacture',
        'totalPaye',
        'totalImpaye',
        'facturesImpayees',
        'dernieresFactures'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('clients', ClientController::class)->except(['destroy']);
    Route::resource('compteurs', CompteurController::class)->except(['destroy']);
    Route::resource('abonnements', AbonnementController::class)->only(['create', 'store', 'destroy']);
    Route::resource('prelevements', PrelevementController::class)->only(['create', 'store']);
    Route::resource('factures', FactureController::class)->only(['index', 'show']);
    Route::resource('facturations', FacturationController::class)->only(['create', 'store']);
    Route::get('/factures/{facture}/pdf', [FactureController::class, 'pdf'])->name('factures.pdf');

    Route::middleware('admin')->group(function () {
        Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
        Route::delete('/compteurs/{compteur}', [CompteurController::class, 'destroy'])->name('compteurs.destroy');
        Route::resource('tarifs', TarifController::class)->except(['show']);
    });
});
require __DIR__.'/auth.php';