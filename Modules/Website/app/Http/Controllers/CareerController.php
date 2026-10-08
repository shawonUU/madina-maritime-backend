<?php

namespace Modules\Website\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Website\App\Models\WebsiteCareerSetting;

class CareerController extends Controller
{
    public function show()
    {
        $career = WebsiteCareerSetting::where('status', true)->first();

        if (!$career) {
            return response()->json([
                'status' => false,
                'message' => 'Career page content not found.',
            ], 404);
        }

        $career->hero_image = $this->imageUrl($career->hero_image);

        return response()->json([
            'status' => true,
            'data' => $career,
        ]);
    }

    public function adminShow()
    {
        $career = WebsiteCareerSetting::first();

        if ($career) {
            $career->hero_image = $this->imageUrl($career->hero_image);
        }

        return response()->json([
            'status' => true,
            'data' => $career,
        ]);
    }

    public function update(Request $request)
    {
        $career = WebsiteCareerSetting::first();

        if (!$career) {
            $career = new WebsiteCareerSetting();
        }

        $validated = $request->validate([
            'hero_label' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_highlight' => ['nullable', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'hero_button_text' => ['nullable', 'string', 'max:255'],
            'hero_button_url' => ['nullable', 'string', 'max:500'],
            'bottom_caption' => ['nullable', 'string', 'max:255'],

            'stats' => ['nullable', 'json'],

            'why_label' => ['nullable', 'string', 'max:255'],
            'why_benefits' => ['nullable', 'json'],

            'jobs_label' => ['nullable', 'string', 'max:255'],
            'jobs_title' => ['nullable', 'string', 'max:255'],
            'jobs_description' => ['nullable', 'string'],

            'status' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('hero_image')) {
            if ($career->hero_image) {
                $oldImage = str_replace('/storage/', '', $career->hero_image);

                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $path = $request->file('hero_image')->store(
                'website/career',
                'public'
            );

            $career->hero_image = '/storage/' . $path;
        }

        $career->hero_label = $request->hero_label;
        $career->hero_title = $request->hero_title;
        $career->hero_highlight = $request->hero_highlight;
        $career->hero_description = $request->hero_description;
        $career->hero_button_text = $request->hero_button_text;
        $career->hero_button_url = $request->hero_button_url;
        $career->bottom_caption = $request->bottom_caption;

        if ($request->filled('stats')) {
            $career->stats = json_decode($request->stats, true);
        }

        $career->why_label = $request->why_label;

        if ($request->filled('why_benefits')) {
            $career->why_benefits = json_decode(
                $request->why_benefits,
                true
            );
        }

        $career->jobs_label = $request->jobs_label;
        $career->jobs_title = $request->jobs_title;
        $career->jobs_description = $request->jobs_description;

        if ($request->has('status')) {
            $career->status = $request->boolean('status');
        }

        $career->save();

        $career->hero_image = $this->imageUrl($career->hero_image);

        return response()->json([
            'status' => true,
            'message' => 'Career page content updated successfully.',
            'data' => $career,
        ]);
    }

    private function imageUrl(?string $image): ?string
    {
        if (!$image) {
            return null;
        }

        if (
            str_starts_with($image, 'http://') ||
            str_starts_with($image, 'https://')
        ) {
            return $image;
        }

        if (str_starts_with($image, '/images/')) {
            return $image;
        }

        if (str_starts_with($image, '/storage/')) {
            return url($image);
        }

        return Storage::disk('public')->url($image);
    }
}