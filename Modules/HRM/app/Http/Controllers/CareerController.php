<?php

namespace Modules\HRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\HRM\App\Jobs\SendRecruitmentEmailJob;
use Modules\HRM\App\Models\JobApplication;
use Modules\HRM\App\Models\JobPost;
use Modules\HRM\App\Models\RecruitmentEmailTemplate;
use Modules\HRM\App\Services\RecruitmentEmailService;

class CareerController extends Controller
{
    public function jobs(Request $request)
    {
        $jobs = JobPost::query()
            ->where('status', 'Published')
            ->where(function ($query) {
                $query
                    ->whereNull('application_deadline')
                    ->orWhereDate(
                        'application_deadline',
                        '>=',
                        now()->toDateString()
                    );
            })
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return response()->json([
            'data' => $jobs,
        ]);
    }

    public function show(string $slug)
    {
        $job = JobPost::query()
            ->where('slug', $slug)
            ->where('status', 'Published')
            ->firstOrFail();

        return response()->json([
            'data' => $job,
        ]);
    }

    public function apply(Request $request, JobPost $jobPost, RecruitmentEmailService $emailService )
    {
        if ($jobPost->status !== 'Published') {
            return response()->json([
                'message' => 'This job is not accepting applications.',
            ], 422);
        }

        if (
            $jobPost->application_deadline &&
            $jobPost->application_deadline->isPast()
        ) {
            return response()->json([
                'message' => 'The application deadline has passed.',
            ], 422);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'current_company' => ['nullable', 'string', 'max:255'],
            'current_position' => ['nullable', 'string', 'max:255'],
            'expected_salary' => ['nullable', 'numeric', 'min:0'],
            'cover_letter' => ['nullable', 'string'],
            'cv' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:5120',
            ],
        ]);

        $cv = $request->file('cv');

        $cvPath = $cv->store(
            'recruitment/cvs',
            'local'
        );

        $applicationNo = 'APP-' .
            now()->format('Ymd') .
            '-' .
            strtoupper(Str::random(6));

        $application = JobApplication::create([
            'job_post_id' => $jobPost->id,
            'application_no' => $applicationNo,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'current_company' => $validated['current_company'] ?? null,
            'current_position' => $validated['current_position'] ?? null,
            'expected_salary' => $validated['expected_salary'] ?? null,
            'cv_path' => $cvPath,
            'cv_original_name' => $cv->getClientOriginalName(),
            'cover_letter' => $validated['cover_letter'] ?? null,
            'status' => 'New',
        ]);

        $application->statusHistories()->create([
            'old_status' => null,
            'new_status' => 'New',
            'note' => 'Application submitted.',
        ]);

        $template = RecruitmentEmailTemplate::where( 'code', 'application_received' )
            ->where('is_active', true)
            ->first();

        if ($template) {
            $log = $emailService->createEmailLog(
                $application,
                $template,
                $emailService->getApplicationVariables(
                    $application
                ),
                'application_received'
            );

            SendRecruitmentEmailJob::dispatch($log->id);
        }

        return response()->json([
            'message' => 'Application submitted successfully.',
            'application_no' => $application->application_no,
        ], 201);
    }
}