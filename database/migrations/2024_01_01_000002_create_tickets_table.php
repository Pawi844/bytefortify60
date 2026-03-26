<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('quantity')->default(100);
            $table->dateTime('sale_start')->nullable();
            $table->dateTime('sale_end')->nullable();
            $table->integer('min_per_order')->default(1);
            $table->integer('max_per_order')->default(10);
            $table->string('ticket_type')->default('paid');
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('tickets'); }
};