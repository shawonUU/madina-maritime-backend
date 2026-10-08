<?php

namespace Modules\Website\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Website\App\Models\WebsiteAbout;

class WebsiteAboutController extends Controller
{
    public function index()
    {
        $about = WebsiteAbout::first();

        if (!$about) {
            return response()->json([
                'status' => true,
                'data' => null,
            ]);
        }

        if ($about->image) {
            $about->image = asset('storage/' . $about->image);
        }

        return response()->json([
            'status' => true,
            'data' => $about,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'highlight' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',

            'journey_description' => 'nullable|string',

            'milestones' => 'nullable|array',
            'mission_title' => 'nullable|string|max:255',
            'mission_description' => 'nullable|string',

            'vision_title' => 'nullable|string|max:255',
            'vision_description' => 'nullable|string',

            'looking_ahead_title' => 'nullable|string|max:255',
            'looking_ahead_description' => 'nullable|string',

            'tonnage' => 'nullable|array',

            'status' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('website/about', 'public');
        }

        $about = WebsiteAbout::create($validated);

        if ($about->image) {
            $about->image = asset('storage/' . $about->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'About information created successfully.',
            'data' => $about,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $about = WebsiteAbout::findOrFail($id);

        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'highlight' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',

            'journey_description' => 'nullable|string',

            'milestones' => 'nullable|array',
            'mission_title' => 'nullable|string|max:255',
            'mission_description' => 'nullable|string',

            'vision_title' => 'nullable|string|max:255',
            'vision_description' => 'nullable|string',

            'looking_ahead_title' => 'nullable|string|max:255',
            'looking_ahead_description' => 'nullable|string',

            'tonnage' => 'nullable|array',

            'status' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if (
                $about->image &&
                Storage::disk('public')->exists($about->image)
            ) {
                Storage::disk('public')->delete($about->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('website/about', 'public');
        }

        $about->update($validated);

        $about->refresh();

        if ($about->image) {
            $about->image = asset('storage/' . $about->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'About information updated successfully.',
            'data' => $about,
        ]);
    }
}