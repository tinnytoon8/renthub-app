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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lease_id')->constrained('leases')->onDelete('cascade');
            $table->string('invoice_number')->unique(); // Contoh: INV-202605-001
            $table->integer('amount_paid');
            $table->date('payment_date');
            $table->string('payment_method'); // Tunai, Transfer Bank
            $table->enum('status', ['pending', 'paid', 'partial'])->default('paid');
            $table->string('proof_of_payment')->nullable(); // Foto bukti transfer
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
