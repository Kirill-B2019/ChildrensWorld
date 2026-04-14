<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('group')->default('general');
            $table->string('key');
            $table->string('locale', 2)->nullable();
            $table->text('value')->nullable();
            $table->timestamps();
            $table->unique(['group', 'key', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
