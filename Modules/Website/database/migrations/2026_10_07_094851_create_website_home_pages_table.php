<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_home_pages', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();

            $table->enum('media_type', [ 'image', 'video']);

            $table->string('media');

            $table->integer('sort_order')->default(0);

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_home_pages');
    }
};