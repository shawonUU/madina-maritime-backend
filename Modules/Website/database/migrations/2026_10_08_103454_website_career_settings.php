<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_career_settings', function (Blueprint $table) {
            $table->id();

            $table->string('hero_label')->nullable();
            $table->string('hero_title')->nullable();
            $table->string('hero_highlight')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_button_text')->nullable();
            $table->string('hero_button_url')->nullable();
            $table->string('bottom_caption')->nullable();

            $table->json('stats')->nullable();

            $table->string('why_label')->nullable();
            $table->json('why_benefits')->nullable();

            $table->string('jobs_label')->nullable();
            $table->string('jobs_title')->nullable();
            $table->text('jobs_description')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_career_settings');
    }
};