<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recruitment_email_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_application_id')
                ->nullable()
                ->constrained('job_applications')
                ->nullOnDelete();

            $table->foreignId('job_post_id')
                ->nullable()
                ->constrained('job_posts')
                ->nullOnDelete();

            $table->foreignId('template_id')
                ->nullable()
                ->constrained('recruitment_email_templates')
                ->nullOnDelete();

            $table->string('recipient_email');
            $table->string('recipient_name')->nullable();

            $table->string('subject');
            $table->string('email_type')->nullable();

            $table->longText('body')->nullable();

            $table->string('status')->default('pending');

            $table->text('error_message')->nullable();

            $table->timestamp('sent_at')->nullable();

            $table->json('meta')->nullable();

            $table->timestamps();

            $table->index('recipient_email');
            $table->index('email_type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recruitment_email_logs');
    }
};