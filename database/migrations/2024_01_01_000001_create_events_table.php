<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('venue')->nullable();
            $table->string('location')->nullable();
            $table->string('timezone')->default('UTC');
            $table->integer('capacity')->nullable();
            $table->string('category')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('status')->default('draft');
            $table->boolean('is_virtual')->default(false);
            $table->string('virtual_link')->nullable();
            $table->string('created_by')->nullable();
            $table->string('website_hero_title')->nullable();
            $table->string('website_hero_subtitle')->nullable();
            $table->string('website_primary_color')->default('#6366f1');
            $table->text('website_about')->nullable();
            $table->boolean('website_show_speakers')->default(true);
            $table->boolean('website_show_schedule')->default(true);
            $table->boolean('website_show_sponsors')->default(true);
            $table->string('custom_domain')->nullable();
            $table->text('badge_settings')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('events'); }
};