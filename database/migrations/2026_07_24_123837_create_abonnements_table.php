<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('compteur_id')->constrained('compteurs')->cascadeOnDelete();
            $table->date('date_abonnement');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('abonnements');
    }
};