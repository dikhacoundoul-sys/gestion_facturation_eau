<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prelevement extends Model
{
    use HasFactory;

    protected $fillable = [
        'compteur_id',
        'date_prelevement',
        'ancien_index',
        'new_index',
    ];
    protected $casts = [
        'date_prelevement' => 'date',
    ];
    public function compteur()
    {
        return $this->belongsTo(Compteur::class);
    }
    public function getConsommationAttribute()
    {
        return $this->new_index - $this->ancien_index;
    }
}