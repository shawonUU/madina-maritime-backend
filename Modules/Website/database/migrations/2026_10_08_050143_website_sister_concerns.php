<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_sister_concerns', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('short_title')->nullable();
            $table->string('category')->nullable();

            $table->text('description')->nullable();

            $table->string('image')->nullable();
            $table->string('icon')->nullable();

            $table->string('number')->nullable();

            $table->integer('sort_order')->default(0);

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_sister_concerns');
    }
};