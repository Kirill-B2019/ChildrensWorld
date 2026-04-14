<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('donation_transactions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('donation_intent_id')->constrained()->cascadeOnDelete();
            $table->string('status', 30)->default('pending');
            $table->string('transaction_id')->nullable();
            $table->string('bank_reference')->nullable();
            $table->decimal('fee', 12, 2)->default(0);
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_transactions');
    }
};
