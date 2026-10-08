<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_vendor_partner_pages', function (Blueprint $table) {
            $table->id();

            $table->string('label')->nullable();
            $table->string('title')->nullable();
            $table->string('highlight')->nullable();
            $table->text('description')->nullable();

            $table->string('hero_image')->nullable();

            $table->string('explore_button_text')->nullable();
            $table->string('explore_button_url')->nullable();

            $table->string('partner_button_text')->nullable();
            $table->string('partner_button_url')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_vendor_partner_pages');
    }
};