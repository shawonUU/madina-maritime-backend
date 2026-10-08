<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_home_settings', function (Blueprint $table) {
            $table->id();

            // Hero / General
            $table->string('hero_label')->nullable();
            $table->string('hero_title')->nullable();
            $table->string('hero_highlight')->nullable();
            $table->string('hero_title_suffix')->nullable();
            $table->text('hero_description')->nullable();

            $table->string('hero_primary_button_text')->nullable();
            $table->string('hero_primary_button_url')->nullable();

            $table->string('hero_secondary_button_text')->nullable();
            $table->string('hero_secondary_button_url')->nullable();

            // Floating Stats
            $table->json('stats')->nullable();

            // About
            $table->string('about_label')->nullable();
            $table->string('about_title')->nullable();
            $table->string('about_highlight')->nullable();
            $table->text('about_description')->nullable();
            $table->text('about_secondary_description')->nullable();
            $table->string('about_image')->nullable();
            $table->string('about_badge_title')->nullable();
            $table->string('about_badge_subtitle')->nullable();
            $table->string('about_button_text')->nullable();
            $table->string('about_button_url')->nullable();
            $table->json('about_points')->nullable();

            // Philosophy
            $table->string('philosophy_label')->nullable();
            $table->string('philosophy_title')->nullable();
            $table->text('philosophy_description')->nullable();
            $table->json('philosophy_items')->nullable();

            // Business
            $table->string('business_label')->nullable();
            $table->string('business_title')->nullable();
            $table->string('business_highlight')->nullable();
            $table->text('business_description')->nullable();
            $table->json('business_divisions')->nullable();

            // Why MML
            $table->string('why_label')->nullable();
            $table->string('why_title')->nullable();
            $table->string('why_highlight')->nullable();
            $table->text('why_description')->nullable();
            $table->json('why_items')->nullable();
            $table->string('why_image')->nullable();

            // Responsible Growth
            $table->string('responsible_title')->nullable();
            $table->text('responsible_description')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_home_settings');
    }
};