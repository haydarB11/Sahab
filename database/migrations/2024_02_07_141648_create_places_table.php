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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('address');
            // $table->string('area');
            $table->string('description');
            $table->boolean('featured')->default(false);
            $table->boolean('available')->default(true);
            $table->boolean('bookable')->default(true);
            // $table->boolean('status')->default(true); // true is active, false is inactive
            $table->double('weekday_price');
            $table->double('weekend_price');
            $table->enum('tag', ['Girls Only', 'Family Only', 'All']); // call migration :)
            $table->timestamps();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('area_id')->nullable()->constrained('areas')->onDelete('set null');
            // $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
