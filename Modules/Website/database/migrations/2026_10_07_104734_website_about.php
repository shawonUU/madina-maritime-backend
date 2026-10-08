<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_abouts', function (Blueprint $table) {
            $table->id();

            $table->string('label')->nullable();
            $table->string('title')->nullable();
            $table->string('highlight')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->text('journey_description')->nullable();
            $table->json('milestones')->nullable();

            $table->string('mission_title')->nullable();
            $table->text('mission_description')->nullable();

            $table->string('vision_title')->nullable();
            $table->text('vision_description')->nullable();

            $table->string('looking_ahead_title')->nullable();
            $table->text('looking_ahead_description')->nullable();

            $table->json('tonnage')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_abouts');
    }
};