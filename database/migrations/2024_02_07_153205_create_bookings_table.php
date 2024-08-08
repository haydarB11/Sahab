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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->datetime('starting_date');
            $table->datetime('ending_date');
            $table->double('total_price');
            $table->double('payment')->nullable();
            $table->string('address')->nullable(); // should i add nullable {place does not have it}
            // $table->enum('payment_method', ['Master Card', 'KNET', 'Visa', 'Apple Pay', 'Google Pay']); // call migration : )
            $table->enum('status', ['placed', 'completed', 'canceled'])->default('placed');
            $table->string('transaction_id')->nullable();
            $table->string('invoice_reference')->nullable();
            $table->string('reference_id')->nullable();
            $table->timestamps();
            $table->foreignId('place_id')->nullable()->constrained('places')->onDelete('set null');
            // ->nullOnDelete(); // test null on delete
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('set null');
            // ->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('promo_code_id')->nullable()->constrained('promo_codes');
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods'); // add it to data base
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
