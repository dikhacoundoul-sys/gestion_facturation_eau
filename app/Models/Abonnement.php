<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'compteur_id',
        'date_abonnement',
    ];
    protected $casts = [
        'date_abonnement' => 'date',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function compteur()
    {
        return $this->belongsTo(Compteur::class);
    }
}