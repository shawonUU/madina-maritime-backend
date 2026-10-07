<?php

namespace Modules\HRM\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\HRM\App\Models\RecruitmentEmailLog;

class SendRecruitmentEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public int $backoff = 30;

    public function __construct(
        public int $emailLogId
    ) {
    }

    public function handle(): void
    {
        $log = RecruitmentEmailLog::find(
            $this->emailLogId
        );

        if (!$log) {
            return;
        }

        if ($log->status === 'sent') {
            return;
        }

        try {
            Mail::html(
                $log->body,
                function ($message) use ($log) {
                    $message
                        ->to(
                            $log->recipient_email,
                            $log->recipient_name
                        )
                        ->subject($log->subject);
                }
            );

            $log->update([
                'status' => 'sent',
                'sent_at' => now(),
                'error_message' => null,
            ]);
        } catch (\Throwable $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            Log::error(
                'Recruitment email failed.',
                [
                    'email_log_id' => $log->id,
                    'error' => $e->getMessage(),
                ]
            );

            throw $e;
        }
    }
}