<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'adresse',
        'telephone',
        'categorie',
    ];
    public function abonnements()
    {
        return $this->hasMany(Abonnement::class);
    }
    public function compteurs()
    {
       return $this->belongsToMany(Compteur::class, 'abonnements')->withPivot('date_abonnement')->withTimestamps();
    }
    public function factures()
    {
        return $this->hasMany(Facture::class);
    }
    public function facturations()
    {
        return $this->hasMany(Facturation::class);
    }
}