<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Constraint\Constraint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('rate');
            $table->timestamps();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('booking_id')->constrained('bookings');
            // $table->foreignId('place_id')->nullable()->constrained('places');
            // $table->foreignId('service_id')->nullable()->constrained('services');
            // $table->foreignId('title_id')->nullable()->constrained('rating_titles');
            // $table->foreignId('message_id')->nullable()->constrained('rating_messages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
