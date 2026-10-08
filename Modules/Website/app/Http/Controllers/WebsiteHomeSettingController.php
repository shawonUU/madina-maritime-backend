<?php

namespace Modules\Website\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Website\App\Models\WebsiteHomeSetting;

class WebsiteHomeSettingController extends Controller
{
    public function index()
    {
        $home = WebsiteHomeSetting::where('status', true)->first();

        if (!$home) {
            return response()->json([
                'status' => false,
                'message' => 'Home page content not found.',
            ], 404);
        }

        $this->transformImages($home);

        return response()->json([
            'status' => true,
            'data' => $home,
        ]);
    }

    public function adminShow()
    {
        $home = WebsiteHomeSetting::first();

        if ($home) {
            $this->transformImages($home);
        }

        return response()->json([
            'status' => true,
            'data' => $home,
        ]);
    }

    public function update(Request $request)
    {
        $home = WebsiteHomeSetting::first();

        if (!$home) {
            $home = new WebsiteHomeSetting();
        }

        $request->validate([
            'hero_label' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_highlight' => ['nullable', 'string', 'max:255'],
            'hero_title_suffix' => ['nullable', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string'],

            'hero_primary_button_text' => ['nullable', 'string', 'max:255'],
            'hero_primary_button_url' => ['nullable', 'string', 'max:500'],

            'hero_secondary_button_text' => ['nullable', 'string', 'max:255'],
            'hero_secondary_button_url' => ['nullable', 'string', 'max:500'],

            'stats' => ['nullable', 'json'],

            'about_label' => ['nullable', 'string', 'max:255'],
            'about_title' => ['nullable', 'string', 'max:255'],
            'about_highlight' => ['nullable', 'string', 'max:255'],
            'about_description' => ['nullable', 'string'],
            'about_secondary_description' => ['nullable', 'string'],
            'about_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'about_badge_title' => ['nullable', 'string', 'max:255'],
            'about_badge_subtitle' => ['nullable', 'string', 'max:255'],
            'about_button_text' => ['nullable', 'string', 'max:255'],
            'about_button_url' => ['nullable', 'string', 'max:500'],
            'about_points' => ['nullable', 'json'],

            'philosophy_label' => ['nullable', 'string', 'max:255'],
            'philosophy_title' => ['nullable', 'string', 'max:500'],
            'philosophy_description' => ['nullable', 'string'],
            'philosophy_items' => ['nullable', 'json'],

            'business_label' => ['nullable', 'string', 'max:255'],
            'business_title' => ['nullable', 'string', 'max:255'],
            'business_highlight' => ['nullable', 'string', 'max:255'],
            'business_description' => ['nullable', 'string'],
            'business_divisions' => ['nullable', 'json'],

            'why_label' => ['nullable', 'string', 'max:255'],
            'why_title' => ['nullable', 'string', 'max:255'],
            'why_highlight' => ['nullable', 'string', 'max:255'],
            'why_description' => ['nullable', 'string'],
            'why_items' => ['nullable', 'json'],
            'why_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],

            'responsible_title' => ['nullable', 'string', 'max:255'],
            'responsible_description' => ['nullable', 'string'],

            'status' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('about_image')) {
            $this->deleteImage($home->about_image);

            $home->about_image = $request->file('about_image')
                ->store('website/home', 'public');
        }

        if ($request->hasFile('why_image')) {
            $this->deleteImage($home->why_image);

            $home->why_image = $request->file('why_image')
                ->store('website/home', 'public');
        }

        $fields = [
            'hero_label',
            'hero_title',
            'hero_highlight',
            'hero_title_suffix',
            'hero_description',
            'hero_primary_button_text',
            'hero_primary_button_url',
            'hero_secondary_button_text',
            'hero_secondary_button_url',

            'about_label',
            'about_title',
            'about_highlight',
            'about_description',
            'about_secondary_description',
            'about_badge_title',
            'about_badge_subtitle',
            'about_button_text',
            'about_button_url',

            'philosophy_label',
            'philosophy_title',
            'philosophy_description',

            'business_label',
            'business_title',
            'business_highlight',
            'business_description',

            'why_label',
            'why_title',
            'why_highlight',
            'why_description',

            'responsible_title',
            'responsible_description',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $home->{$field} = $request->input($field);
            }
        }

        $jsonFields = [
            'stats',
            'about_points',
            'philosophy_items',
            'business_divisions',
            'why_items',
        ];

        foreach ($jsonFields as $field) {
            if ($request->filled($field)) {
                $decoded = json_decode(
                    $request->input($field),
                    true
                );

                if (json_last_error() === JSON_ERROR_NONE) {
                    $home->{$field} = $decoded;
                }
            }
        }

        if ($request->has('status')) {
            $home->status = $request->boolean('status');
        }

        $home->save();

        $this->transformImages($home);

        return response()->json([
            'status' => true,
            'message' => 'Home page content updated successfully.',
            'data' => $home,
        ]);
    }

    private function transformImages($home): void
    {
        if ($home->about_image) {
            $home->about_image = $this->imageUrl(
                $home->about_image
            );
        }

        if ($home->why_image) {
            $home->why_image = $this->imageUrl(
                $home->why_image
            );
        }

        $philosophyItems = $home->philosophy_items;

        if (is_array($philosophyItems)) {
            foreach ($philosophyItems as $index => $item) {
                if (!empty($item['img'])) {
                    $philosophyItems[$index]['img'] = $this->imageUrl(
                        $item['img']
                    );
                }
            }

            $home->philosophy_items = $philosophyItems;
        }

        $businessDivisions = $home->business_divisions;

        if (is_array($businessDivisions)) {
            foreach ($businessDivisions as $index => $item) {
                if (!empty($item['image'])) {
                    $businessDivisions[$index]['image'] = $this->imageUrl(
                        $item['image']
                    );
                }
            }

            $home->business_divisions = $businessDivisions;
        }
    }

    private function imageUrl(?string $path): ?string
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

        if (str_starts_with($path, '/storage/')) {
            return url($path);
        }

        return Storage::disk('public')->url($path);
    }

    private function deleteImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        $path = str_replace('/storage/', '', $path);

        if (
            !str_starts_with($path, 'http://') &&
            !str_starts_with($path, 'https://') &&
            Storage::disk('public')->exists($path)
        ) {
            Storage::disk('public')->delete($path);
        }
    }
}