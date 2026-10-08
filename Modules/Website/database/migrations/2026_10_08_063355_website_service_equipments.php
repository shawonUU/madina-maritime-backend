<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_service_equipments', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('name');
            $table->string('units')->nullable();
            $table->text('description');
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(1);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_service_equipments');
    }
};