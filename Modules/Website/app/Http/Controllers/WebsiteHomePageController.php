<?php

namespace Modules\Website\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Website\App\Models\WebsiteHomePage;

class WebsiteHomePageController extends Controller
{
    public function index()
    {
        $slides = WebsiteHomePage::orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $slides->transform(function ($slide) {
            if ($slide->media) {
                $slide->media = $this->mediaUrl($slide->media);
            }

            return $slide;
        });

        return response()->json([
            'status' => true,
            'data' => $slides,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'media_type' => 'required|in:image,video',
            'media' => 'required|file|mimes:jpg,jpeg,png,webp,mp4,webm,mov|max:51200',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $file = $request->file('media');

        if ($request->media_type === 'image') {
            $request->validate([
                'media' => 'required|file|mimes:jpg,jpeg,png,webp|max:10240',
            ]);
        }

        if ($request->media_type === 'video') {
            $request->validate([
                'media' => 'required|file|mimes:mp4,webm,mov|max:51200',
            ]);
        }

        $path = $file->store('website/hero-slides', 'public');

        $slide = WebsiteHomePage::create([
            'title' => $validated['title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'media_type' => $validated['media_type'],
            'media' => $path,
            'sort_order' => $validated['sort_order'] ?? 0,
            'status' => $validated['status'] ?? true,
        ]);

        $slide->media = $this->mediaUrl($slide->media);

        return response()->json([
            'status' => true,
            'message' => 'Hero slide created successfully.',
            'data' => $slide,
        ], 201);
    }

    public function show($id)
    {
        $slide = WebsiteHomePage::findOrFail($id);

        if ($slide->media) {
            $slide->media = $this->mediaUrl($slide->media);
        }

        return response()->json([
            'status' => true,
            'data' => $slide,
        ]);
    }

    public function update(Request $request, $id)
    {
        $slide = WebsiteHomePage::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'media_type' => 'required|in:image,video',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,webm,mov|max:51200',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        if ($request->hasFile('media')) {
            if (
                $slide->media &&
                !str_starts_with($slide->media, '/images/') &&
                !str_starts_with($slide->media, 'http://') &&
                !str_starts_with($slide->media, 'https://') &&
                Storage::disk('public')->exists($slide->media)
            ) {
                Storage::disk('public')->delete($slide->media);
            }

            if ($request->media_type === 'image') {
                $request->validate([
                    'media' => 'required|file|mimes:jpg,jpeg,png,webp|max:10240',
                ]);
            }

            if ($request->media_type === 'video') {
                $request->validate([
                    'media' => 'required|file|mimes:mp4,webm,mov|max:51200',
                ]);
            }

            $path = $request->file('media')
                ->store('website/hero-slides', 'public');

            $slide->media = $path;
        }

        $slide->title = $validated['title'] ?? null;
        $slide->subtitle = $validated['subtitle'] ?? null;
        $slide->media_type = $validated['media_type'];
        $slide->sort_order = $validated['sort_order'] ?? 0;
        $slide->status = $validated['status'] ?? true;

        $slide->save();

        $slide->media = $this->mediaUrl($slide->media);

        return response()->json([
            'status' => true,
            'message' => 'Hero slide updated successfully.',
            'data' => $slide,
        ]);
    }

    public function destroy($id)
    {
        $slide = WebsiteHomePage::findOrFail($id);

        if (
            $slide->media &&
            !str_starts_with($slide->media, '/images/') &&
            !str_starts_with($slide->media, 'http://') &&
            !str_starts_with($slide->media, 'https://') &&
            Storage::disk('public')->exists($slide->media)
        ) {
            Storage::disk('public')->delete($slide->media);
        }

        $slide->delete();

        return response()->json([
            'status' => true,
            'message' => 'Hero slide deleted successfully.',
        ]);
    }

    protected function mediaUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (
            str_starts_with($path, 'http://') ||
            str_starts_with($path, 'https://') ||
            str_starts_with($path, '/images/')
        ) {
            return $path;
        }

        return rtrim(config('app.url'), '/') . '/storage/' . ltrim($path, '/');
    }
}