<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_post_id')
                ->constrained('job_posts')
                ->cascadeOnDelete();

            $table->string('application_no')->unique();

            $table->string('name');

            $table->string('email');

            $table->string('phone');

            $table->text('address')->nullable();

            $table->string('current_company')->nullable();

            $table->string('current_position')->nullable();

            $table->decimal('expected_salary', 12, 2)->nullable();

            $table->string('cv_path');

            $table->string('cv_original_name')->nullable();

            $table->text('cover_letter')->nullable();

            $table->enum('status', [
                'New',
                'Shortlisted',
                'Interview',
                'Selected',
                'Rejected',
            ])->default('New');

            $table->text('hr_note')->nullable();

            $table->timestamp('shortlisted_at')->nullable();

            $table->timestamp('interview_at')->nullable();

            $table->timestamp('selected_at')->nullable();

            $table->timestamp('rejected_at')->nullable();

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('status');
            $table->index('email');
            $table->index('phone');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};