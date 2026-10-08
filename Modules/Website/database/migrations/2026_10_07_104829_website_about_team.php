<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_about_teams', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('designation');
            $table->enum('category', [
                'management',
                'leadership'
            ]);

            $table->string('image')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_about_teams');
    }
};