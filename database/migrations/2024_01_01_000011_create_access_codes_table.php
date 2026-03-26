<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('access_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('code')->unique();
            $table->string('discount_type')->default('percentage');
            $table->decimal('discount', 10, 2)->default(0);
            $table->integer('max_uses')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('access_codes'); }
};