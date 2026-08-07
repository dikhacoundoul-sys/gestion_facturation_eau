<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_serie',
        'attribue',
        'ancien_index',
    ];
    protected $casts = [
        'attribue' => 'boolean',
    ];
    public function abonnements()
    {
        return $this->hasMany(Abonnement::class);
    }
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'abonnements')
                     ->withPivot('date_abonnement')
                     ->withTimestamps();
    }
    public function factures()
    {
        return $this->hasMany(Facture::class);
    }
    public function facturations()
    {
        return $this->hasMany(Facturation::class);
    }
    public function prelevements()
    {
        return $this->hasMany(Prelevement::class);
    }
}