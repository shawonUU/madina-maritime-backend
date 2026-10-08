<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_contact_settings', function (Blueprint $table) {
            $table->id();

            $table->string('hero_label')->default('Madina Maritime Limited');
            $table->string('hero_title')->default("Let's start a");
            $table->string('hero_highlight')->default('conversation.');
            $table->text('hero_description')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_button_text')->default('Send an Enquiry');
            $table->string('hero_button_url')->default('#contact-form');
            $table->string('bottom_caption')->default('Connecting Through The Sea');

            $table->string('address_label')->default('Visit Us');
            $table->string('office_title')->default('Head Office');
            $table->text('address')->nullable();

            $table->string('phone_label')->default('Call Us');
            $table->text('phone_title')->nullable();
            $table->text('phone_description')->nullable();

            $table->string('email_label')->default('Email Us');
            $table->string('email')->nullable();

            $table->string('hours_label')->default('Working Hours');
            $table->string('working_days')->default('Sunday – Thursday');
            $table->string('working_hours')->default('9:00 AM – 6:00 PM');

            $table->string('form_label')->default('Send a Message');
            $table->string('form_title')->default('Tell us how we can help.');
            $table->text('form_description')->nullable();

            $table->string('map_title')->default('Our Location');
            $table->text('map_embed_url')->nullable();

            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_contact_settings');
    }
};