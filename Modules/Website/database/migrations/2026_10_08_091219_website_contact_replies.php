<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_contact_replies', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contact_message_id')
                ->constrained('website_contact_messages')
                ->cascadeOnDelete();

            $table->text('reply_message');
            $table->string('replied_by')->nullable();
            $table->string('recipient_email');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_contact_replies');
    }
};