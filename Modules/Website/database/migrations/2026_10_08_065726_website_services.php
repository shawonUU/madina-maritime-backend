<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_services', function (Blueprint $table) {
            $table->id();
            $table->string('number', 20);
            $table->string('title');
            $table->text('description');
            $table->string('icon')->default('Ship');
            $table->integer('sort_order')->default(1);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_services');
    }
};