<?php

namespace Modules\HRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\HRM\App\Models\JobPost;

class JobPostController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPost::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jobs = $query
            ->orderBy('sort_order')
            ->latest()
            ->paginate(
                $request->integer('per_page', 20)
            );

        return response()->json($jobs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'employment_type' => ['required', 'in:Full-time,Part-time,Contract,Internship,Remote'],
            'experience' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'responsibilities' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'application_deadline' => ['nullable', 'date'],
            'status' => ['required', 'in:Draft,Published,Closed'],
            'is_featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

        $job = JobPost::create($validated);

        return response()->json([
            'message' => 'Job post created successfully.',
            'data' => $job,
        ], 201);
    }

    public function show(JobPost $jobPost)
    {
        return response()->json([
            'data' => $jobPost,
        ]);
    }

    public function update(Request $request, JobPost $jobPost)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'employment_type' => ['required', 'in:Full-time,Part-time,Contract,Internship,Remote'],
            'experience' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'responsibilities' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'application_deadline' => ['nullable', 'date'],
            'status' => ['required', 'in:Draft,Published,Closed'],
            'is_featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['title'],$jobPost->id);

        $jobPost->update($validated);

        return response()->json([
            'message' => 'Job post updated successfully.',
            'data' => $jobPost->fresh(),
        ]);
    }

    public function destroy(JobPost $jobPost)
    {
        $jobPost->delete();

        return response()->json([
            'message' => 'Job post deleted successfully.',
        ]);
    }

    private function generateUniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $slug = Str::slug($value);

        if ($slug === '') {
            $slug = 'job-post';
        }

        $originalSlug = $slug;
        $counter = 1;

        while (
            JobPost::where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) => $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
