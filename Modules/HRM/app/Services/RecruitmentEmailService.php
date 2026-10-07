<?php

namespace Modules\HRM\App\Services;

use Illuminate\Support\Str;
use Modules\HRM\App\Models\JobApplication;
use Modules\HRM\App\Models\RecruitmentEmailLog;
use Modules\HRM\App\Models\RecruitmentEmailTemplate;

class RecruitmentEmailService
{
    public function createEmailLog(
        JobApplication $application,
        RecruitmentEmailTemplate $template,
        array $variables = [],
        ?string $emailType = null
    ): RecruitmentEmailLog {
        $subject = $this->replaceVariables(
            $template->subject,
            $variables
        );

        $body = $this->replaceVariables(
            $template->body,
            $variables
        );

        return RecruitmentEmailLog::create([
            'job_application_id' => $application->id,
            'job_post_id' => $application->job_post_id,
            'template_id' => $template->id,
            'recipient_email' => $application->email,
            'recipient_name' => $application->name,
            'subject' => $subject,
            'email_type' => $emailType ?: $template->code,
            'body' => $body,
            'status' => 'pending',
            'meta' => [
                'variables' => $variables,
            ],
        ]);
    }

    public function replaceVariables(
        string $content,
        array $variables
    ): string {
        foreach ($variables as $key => $value) {
            $content = str_replace(
                '{{' . $key . '}}',
                (string) ($value ?? ''),
                $content
            );
        }

        return $content;
    }

    public function getApplicationVariables(
        JobApplication $application,
        array $extra = []
    ): array {
        $application->loadMissing('jobPost');

        return array_merge([
            'applicant_name' => $application->name,
            'applicant_email' => $application->email,
            'applicant_phone' => $application->phone,
            'application_no' => $application->application_no,
            'job_title' => $application->jobPost?->title,
            'department' => $application->jobPost?->department,
            'location' => $application->jobPost?->location,
            'employment_type' => $application->jobPost?->employment_type,
        ], $extra);
    }
}