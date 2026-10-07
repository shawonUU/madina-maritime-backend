<?php

namespace Modules\HRM\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\HRM\App\Models\JobApplication;

class ApplicationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public JobApplication $application
    ) {
    }

    public function build()
    {
        return $this
            ->subject(
                'Application Update - ' .
                $this->application->jobPost->title
            )
            ->view('hrm::emails.application-status');
    }
}