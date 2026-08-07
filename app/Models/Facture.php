<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'compteur_id',
        'solde_anterieur',
        'consommation',
        'montant',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function compteur()
    {
        return $this->belongsTo(Compteur::class);
    }
    public function facturations()
    {
        return $this->hasMany(Facturation::class);
    }
}