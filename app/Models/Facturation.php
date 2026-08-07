<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturation extends Model
{
    use HasFactory;

    protected $fillable = [
        'facture_id',
        'client_id',
        'compteur_id',
        'date_paiement',
        'mensualite',
        'reglement',
    ];
    protected $casts = [
        'date_paiement' => 'date',
    ];
    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function compteur()
    {
        return $this->belongsTo(Compteur::class);
    }
}