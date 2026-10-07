<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->string('slug')->unique();

            $table->string('department')->nullable();

            $table->string('location')
                ->default('Dhaka, Bangladesh');

            $table->enum('employment_type', [
                'Full-time',
                'Part-time',
                'Contract',
                'Internship',
                'Remote',
            ])->default('Full-time');

            $table->string('experience')->nullable();

            $table->text('short_description')->nullable();

            $table->longText('description')->nullable();

            $table->longText('responsibilities')->nullable();

            $table->longText('requirements')->nullable();

            $table->longText('benefits')->nullable();

            $table->date('application_deadline')->nullable();

            $table->enum('status', [
                'Draft',
                'Published',
                'Closed',
            ])->default('Draft');

            $table->boolean('is_featured')->default(false);

            $table->integer('sort_order')->default(0);

            $table->timestamps();

            $table->index('status');
            $table->index('employment_type');
            $table->index('application_deadline');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};