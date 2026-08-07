<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prelevements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compteur_id')->constrained('compteurs')->cascadeOnDelete();
            $table->date('date_prelevement');
            $table->integer('ancien_index');
            $table->integer('new_index');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prelevements');
    }
};