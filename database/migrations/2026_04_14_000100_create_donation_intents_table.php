<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('donation_intents', function (Blueprint $table): void {
            $table->id();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('KGS');
            $table->string('type', 20)->default('one_time');
            $table->string('campaign')->nullable();
            $table->string('donor_name')->nullable();
            $table->string('donor_email')->nullable();
            $table->string('donor_phone')->nullable();
            $table->string('locale', 2)->default('en');
            $table->string('status', 30)->default('created');
            $table->string('external_reference')->unique();
            $table->uuid('idempotency_key')->unique();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_intents');
    }
};
