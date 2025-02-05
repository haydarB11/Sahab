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
        Schema::create('place_amenities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('place_id')->constrained('places')->onDelete('cascade');
            $table->foreignId('amenity_id')->constrained('amenities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('place_amenities');
    }
};
