<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mail_communications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('subject');
            $table->text('body');
            $table->string('recipients')->default('all');
            $table->string('status')->default('draft');
            $table->string('sent_by')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->integer('sent_count')->default(0);
            $table->dateTime('send_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('mail_communications'); }
};