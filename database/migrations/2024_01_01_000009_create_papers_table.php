<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('author_id')->constrained('attendees')->onDelete('cascade');
            $table->string('title');
            $table->text('abstract');
            $table->string('keywords')->nullable();
            $table->string('status')->default('submitted');
            $table->text('decision_comment')->nullable();
            $table->dateTime('decided_at')->nullable();
            $table->text('extra_data')->nullable();
            $table->timestamps();
        });

        Schema::create('paper_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paper_id')->constrained()->onDelete('cascade');
            $table->foreignId('reviewer_id')->nullable()->constrained('attendees')->nullOnDelete();
            $table->integer('score')->default(5);
            $table->text('comments');
            $table->string('recommendation');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('paper_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('label');
            $table->string('field_type')->default('text');
            $table->text('options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->integer('sort_order')->default(0);
            $table->string('help_text')->nullable();
            $table->timestamps();
        });

        Schema::create('paper_field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paper_id')->constrained()->onDelete('cascade');
            $table->foreignId('paper_field_id')->constrained()->onDelete('cascade');
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paper_field_values');
        Schema::dropIfExists('paper_fields');
        Schema::dropIfExists('paper_reviews');
        Schema::dropIfExists('papers');
    }
};