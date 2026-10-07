<?php

namespace Modules\HRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\HRM\App\Jobs\SendRecruitmentEmailJob;
use Modules\HRM\App\Models\JobApplication;
use Modules\HRM\App\Models\RecruitmentEmailLog;
use Modules\HRM\App\Models\RecruitmentEmailTemplate;
use Modules\HRM\App\Services\RecruitmentEmailService;

class RecruitmentEmailController extends Controller
{
    public function templates()
    {
        $templates = RecruitmentEmailTemplate::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return response()->json([
            'data' => $templates,
        ]);
    }

    public function preview(
        Request $request,
        RecruitmentEmailService $emailService
    ) {
        $validated = $request->validate([
            'application_id' => [
                'required',
                'integer',
                'exists:job_applications,id',
            ],
            'template_id' => [
                'required',
                'integer',
                'exists:recruitment_email_templates,id',
            ],
            'interview_date' => ['nullable', 'date'],
            'interview_time' => ['nullable', 'string', 'max:50'],
            'interview_mode' => ['nullable', 'string', 'max:100'],
            'interview_location' => ['nullable', 'string', 'max:500'],
            'meeting_link' => ['nullable', 'url', 'max:1000'],
            'interview_note' => ['nullable', 'string'],
        ]);

        $application = JobApplication::with('jobPost')
            ->findOrFail($validated['application_id']);

        $template = RecruitmentEmailTemplate::findOrFail(
            $validated['template_id']
        );

        $variables = $emailService->getApplicationVariables(
            $application,
            [
                'interview_date' => $validated['interview_date'] ?? '',
                'interview_time' => $validated['interview_time'] ?? '',
                'interview_mode' => $validated['interview_mode'] ?? '',
                'interview_location' => $validated['interview_location'] ?? '',
                'meeting_link' => $validated['meeting_link'] ?? '',
                'interview_note' => $validated['interview_note'] ?? '',
            ]
        );

        return response()->json([
            'data' => [
                'subject' => $emailService->replaceVariables(
                    $template->subject,
                    $variables
                ),
                'body' => $emailService->replaceVariables(
                    $template->body,
                    $variables
                ),
                'recipient_name' => $application->name,
                'recipient_email' => $application->email,
            ],
        ]);
    }

    public function send(
        Request $request,
        RecruitmentEmailService $emailService
    ) {
        $validated = $request->validate([
            'application_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'application_ids.*' => [
                'integer',
                'exists:job_applications,id',
            ],

            'template_id' => [
                'required',
                'integer',
                'exists:recruitment_email_templates,id',
            ],

            'interview_date' => ['nullable', 'date'],
            'interview_time' => ['nullable', 'string', 'max:50'],
            'interview_mode' => ['nullable', 'string', 'max:100'],
            'interview_location' => ['nullable', 'string', 'max:500'],
            'meeting_link' => ['nullable', 'url', 'max:1000'],
            'interview_note' => ['nullable', 'string'],
        ]);

        $template = RecruitmentEmailTemplate::findOrFail(
            $validated['template_id']
        );

        $applications = JobApplication::with('jobPost')
            ->whereIn(
                'id',
                $validated['application_ids']
            )
            ->get();

        $logs = [];

        foreach ($applications as $application) {
            $variables = $emailService->getApplicationVariables(
                $application,
                [
                    'interview_date' => $validated['interview_date'] ?? '',
                    'interview_time' => $validated['interview_time'] ?? '',
                    'interview_mode' => $validated['interview_mode'] ?? '',
                    'interview_location' => $validated['interview_location'] ?? '',
                    'meeting_link' => $validated['meeting_link'] ?? '',
                    'interview_note' => $validated['interview_note'] ?? '',
                ]
            );

            $log = $emailService->createEmailLog(
                $application,
                $template,
                $variables,
                $template->code
            );

            $logs[] = $log;

            SendRecruitmentEmailJob::dispatch(
                $log->id
            );
        }

        return response()->json([
            'message' => count($logs) .
                ' email(s) queued successfully.',
            'count' => count($logs),
        ], 201);
    }

    public function logs(Request $request)
    {
        $validated = $request->validate([
            'application_id' => [
                'nullable',
                'integer',
                'exists:job_applications,id',
            ],
            'job_post_id' => [
                'nullable',
                'integer',
                'exists:job_posts,id',
            ],
        ]);

        $logs = RecruitmentEmailLog::query()
            ->with([
                'template',
                'application',
                'jobPost',
            ])
            ->when(
                $request->filled('application_id'),
                function ($query) use ($request) {
                    $query->where(
                        'job_application_id',
                        $request->application_id
                    );
                }
            )
            ->when(
                $request->filled('job_post_id'),
                function ($query) use ($request) {
                    $query->where(
                        'job_post_id',
                        $request->job_post_id
                    );
                }
            )
            ->latest()
            ->paginate(20);

        return response()->json([
            'data' => $logs,
        ]);
    }
}