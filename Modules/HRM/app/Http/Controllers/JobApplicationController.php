<?php

namespace Modules\HRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\HRM\App\Models\JobApplication;
use Modules\HRM\App\Models\JobPost;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'job_post_id' => ['required', 'integer', 'exists:job_posts,id'],
            'status' => [
                'nullable',
                'in:New,Shortlisted,Interview,Selected,Rejected',
            ],
            'search' => ['nullable', 'string', 'max:255'],
            'per_page' => ['nullable', 'integer', 'min:5', 'max:100'],
        ]);

        $jobPost = JobPost::findOrFail($request->job_post_id);

        $applications = JobApplication::query()
            ->with('jobPost')
            ->where('job_post_id', $jobPost->id)
            ->when(
                $request->filled('status'),
                function ($query) use ($request) {
                    $query->where('status', $request->status);
                }
            )
            ->when(
                $request->filled('search'),
                function ($query) use ($request) {
                    $search = $request->search;

                    $query->where(function ($q) use ($search) {
                        $q->where('application_no', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
                }
            )
            ->latest()
            ->paginate($request->integer('per_page', 15));

        return response()->json([
            'data' => $applications,
            'job_post' => $jobPost,
        ]);
    }

    public function show(JobApplication $jobApplication)
    {
        $jobApplication->load([
            'jobPost',
            'statusHistories' => function ($query) {
                $query->latest();
            },
        ]);

        return response()->json([
            'data' => $jobApplication,
        ]);
    }

    public function updateStatus(
        Request $request,
        JobApplication $jobApplication
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:New,Shortlisted,Interview,Selected,Rejected',
            ],
            'note' => ['nullable', 'string'],
        ]);

        $oldStatus = $jobApplication->status;
        $newStatus = $validated['status'];

        if ($oldStatus === $newStatus) {
            return response()->json([
                'message' => 'Application is already in this status.',
                'data' => $jobApplication,
            ]);
        }

        $jobApplication->update([
            'status' => $newStatus,
        ]);

        $jobApplication->statusHistories()->create([
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'note' => $validated['note'] ?? null,
        ]);

        $jobApplication->load([
            'jobPost',
            'statusHistories' => function ($query) {
                $query->latest();
            },
        ]);

        return response()->json([
            'message' => 'Application status updated successfully.',
            'data' => $jobApplication,
        ]);
    }

    public function downloadCv(JobApplication $jobApplication)
    {
        if (
            !$jobApplication->cv_path ||
            !Storage::disk('local')->exists($jobApplication->cv_path)
        ) {
            return response()->json([
                'message' => 'CV file not found.',
            ], 404);
        }

        $path = Storage::disk('local')->path(
            $jobApplication->cv_path
        );

        $fileName = $jobApplication->cv_original_name
            ?: basename($path);

        return response()->file($path, [
            'Content-Disposition' => 'inline; filename="' .
                addslashes($fileName) .
                '"',
        ]);
    }
}