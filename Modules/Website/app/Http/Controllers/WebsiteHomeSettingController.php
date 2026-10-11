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

        return response()->json([
            'status' => true,
            'data' => $this->formatHome($home),
        ]);
    }

    public function adminShow()
    {
        $home = WebsiteHomeSetting::first();

        return response()->json([
            'status' => true,
            'data' => $home ? $this->formatHome($home) : null,
        ]);
    }

    public function update(Request $request)
    {
        $home = WebsiteHomeSetting::first() ?? new WebsiteHomeSetting();

        $request->validate([
            'hero_label' => 'sometimes|nullable|string|max:255',
            'hero_title' => 'sometimes|nullable|string|max:255',
            'hero_highlight' => 'sometimes|nullable|string|max:255',
            'hero_title_suffix' => 'sometimes|nullable|string|max:255',
            'hero_description' => 'sometimes|nullable|string',

            'hero_primary_button_text' => 'sometimes|nullable|string|max:255',
            'hero_primary_button_url' => 'sometimes|nullable|string|max:500',
            'hero_secondary_button_text' => 'sometimes|nullable|string|max:255',
            'hero_secondary_button_url' => 'sometimes|nullable|string|max:500',

            'stats' => 'sometimes|nullable|json',

            'about_label' => 'sometimes|nullable|string|max:255',
            'about_title' => 'sometimes|nullable|string|max:255',
            'about_highlight' => 'sometimes|nullable|string|max:255',
            'about_description' => 'sometimes|nullable|string',
            'about_secondary_description' => 'sometimes|nullable|string',
            'about_image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'about_badge_title' => 'sometimes|nullable|string|max:255',
            'about_badge_subtitle' => 'sometimes|nullable|string|max:255',
            'about_floating_title' => 'sometimes|nullable|string|max:255',
            'about_floating_subtitle' => 'sometimes|nullable|string|max:255',
            'about_button_text' => 'sometimes|nullable|string|max:255',
            'about_button_url' => 'sometimes|nullable|string|max:500',
            'about_points' => 'sometimes|nullable|json',

            'philosophy_label' => 'sometimes|nullable|string|max:255',
            'philosophy_title' => 'sometimes|nullable|string|max:500',
            'philosophy_description' => 'sometimes|nullable|string',
            'philosophy_items' => 'sometimes|nullable|json',

            'business_label' => 'sometimes|nullable|string|max:255',
            'business_title' => 'sometimes|nullable|string|max:255',
            'business_highlight' => 'sometimes|nullable|string|max:255',
            'business_description' => 'sometimes|nullable|string',
            'business_divisions' => 'sometimes|nullable|json',

            'why_label' => 'sometimes|nullable|string|max:255',
            'why_title' => 'sometimes|nullable|string|max:255',
            'why_highlight' => 'sometimes|nullable|string|max:255',
            'why_description' => 'sometimes|nullable|string',
            'why_items' => 'sometimes|nullable|json',
            'why_image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'responsible_title' => 'sometimes|nullable|string|max:255',
            'responsible_description' => 'sometimes|nullable|string',

            'status' => 'sometimes|boolean',

            'philosophy_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'business_division_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        foreach (['about_image', 'why_image'] as $field) {
            if ($request->hasFile($field)) {
                $this->deleteImage($home->{$field});

                $home->{$field} = $request->file($field)
                    ->store('website/home', 'public');
            }
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
            'about_floating_title',
            'about_floating_subtitle',
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
            if ($request->exists($field)) {
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
            if (!$request->exists($field)) {
                continue;
            }

            $value = $request->input($field);

            if (is_string($value)) {
                $value = json_decode($value, true);
            }

            if (is_array($value)) {
                $home->{$field} = $value;
            }
        }

        $this->saveNestedImages(
            $request,
            $home,
            'philosophy_items',
            'philosophy_images',
            'img'
        );

        $this->saveNestedImages(
            $request,
            $home,
            'business_divisions',
            'business_division_images',
            'image'
        );

        if ($request->has('status')) {
            $home->status = $request->boolean('status');
        }

        $home->save();
        $home->refresh();

        return response()->json([
            'status' => true,
            'message' => 'Home page content updated successfully.',
            'data' => $this->formatHome($home),
        ]);
    }

    private function saveNestedImages(
        Request $request,
        WebsiteHomeSetting $home,
        string $jsonField,
        string $uploadField,
        string $imageKey
    ): void {
        if (!$request->hasFile($uploadField)) {
            return;
        }

        $items = $home->{$jsonField} ?? [];

        if (!is_array($items)) {
            return;
        }

        foreach ($items as $index => &$item) {
            $file = $request->file("{$uploadField}.{$index}");

            if (!$file) {
                continue;
            }

            if (!empty($item[$imageKey])) {
                $this->deleteImage($item[$imageKey]);
            }

            $item[$imageKey] = $file->store(
                'website/home',
                'public'
            );
        }

        unset($item);

        $home->{$jsonField} = $items;
    }

    private function formatHome(WebsiteHomeSetting $home): array
    {
        $data = $home->toArray();

        foreach (['about_image', 'why_image'] as $field) {
            if (!empty($data[$field])) {
                $data[$field] = $this->imageUrl($data[$field]);
            }
        }

        foreach ([
            ['philosophy_items', 'img'],
            ['business_divisions', 'image'],
        ] as [$field, $imageKey]) {
            if (!empty($data[$field]) && is_array($data[$field])) {
                foreach ($data[$field] as &$item) {
                    if (!empty($item[$imageKey])) {
                        $item[$imageKey] = $this->imageUrl(
                            $item[$imageKey]
                        );
                    }
                }

                unset($item);
            }
        }

        // Names used by the public homepage component.
        $data['hero_brand_label'] = $data['hero_label'] ?? null;
        $data['hero_title_bottom'] = $data['hero_title_suffix'] ?? null;
        $data['about_checklist'] = $data['about_points'] ?? [];
        $data['missions'] = $data['philosophy_items'] ?? [];
        $data['divisions'] = $data['business_divisions'] ?? [];
        $data['why_floating_title'] = $data['responsible_title'] ?? null;
        $data['why_floating_description'] =
            $data['responsible_description'] ?? null;

        return $data;
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

        if (str_starts_with($path, '/storage/')) {
            $path = substr($path, strlen('/storage/'));
        } elseif (
            str_starts_with($path, 'http://') ||
            str_starts_with($path, 'https://')
        ) {
            $urlPath = parse_url($path, PHP_URL_PATH);

            if (!$urlPath || !str_starts_with($urlPath, '/storage/')) {
                return;
            }

            $path = substr($urlPath, strlen('/storage/'));
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
