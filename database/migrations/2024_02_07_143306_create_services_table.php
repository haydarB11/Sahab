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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            // $table->string('image');
            $table->time('notice_period');
            $table->integer('duration');
            $table->integer('max_capacity');
            $table->double('price');
            $table->string('description');
            $table->boolean('featured')->default(false);
            $table->boolean('available')->default(true);
            $table->boolean('bookable')->default(true);
            // $table->enum('tag', ['Girls Only', 'Family Only', 'All']);
            $table->timestamps();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
