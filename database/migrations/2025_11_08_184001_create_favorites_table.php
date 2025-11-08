<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();

            // Kunci Asing ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Kunci Asing ke tabel cultures
            $table->foreignId('culture_id')->constrained('cultures')->onDelete('cascade');
            
            // Mencegah duplikasi: satu pengguna hanya bisa memfavoritkan satu budaya sekali
            $table->unique(['user_id', 'culture_id']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};