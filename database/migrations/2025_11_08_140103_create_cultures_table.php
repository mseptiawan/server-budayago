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
        Schema::create('cultures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            
            // Kategori Budaya: tarian, kuliner, busana adat, kriya, upacara adat, arsitektur, seni tradisional
            $table->string('category'); 

            // Lokasi
            $table->string('province'); // Untuk Filter dan Peta
            $table->string('city_or_regency'); 

            // Deskripsi
            $table->text('short_description'); // Untuk List Budaya
            $table->longText('long_description'); // Untuk Detail Budaya & Fitur Voice

            // Media
            $table->string('image_url')->nullable(); 
            $table->string('video_url')->nullable();
            $table->string('virtual_tour_url')->nullable(); // Untuk 360 (null jika tidak ada)

            // Relasi Admin yang memposting (Wajib diisi jika fitur admin sudah diterapkan)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cultures');
    }
};