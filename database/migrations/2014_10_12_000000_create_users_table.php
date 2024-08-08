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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->default('');
            $table->string('phone', 20)->unique();
            $table->integer('commission')->default(90);
            $table->string('supplier_code')->default('');
            $table->enum('status', ['activated', 'deactivated'])->default('activated');
            $table->enum('role', ['user', 'vendor'])->default('user');
            $table->string('email')->unique();
            // $table->string('email')->default(''); // what about unique
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
