<?php

namespace Modules\Website\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Website\App\Models\WebsiteSisterConcern;
use Modules\Website\App\Models\WebsiteSisterConcernPage;
use Modules\Website\App\Models\WebsiteSisterConcernSector;
use Modules\Website\App\Models\WebsiteSisterOrganization;

class SisterConcernController extends Controller
{
    public function index()
    {
        $page = WebsiteSisterConcernPage::query()
            ->where('status', true)
            ->first();

        $sectors = WebsiteSisterConcernSector::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->get();

        $concerns = WebsiteSisterConcern::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) {
                $item->image_url = $this->imageUrl($item->image);

                return $item;
            });

        $organizations = WebsiteSisterOrganization::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->get();

        if ($page) {
            $page->hero_image_url = $this->imageUrl($page->hero_image);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'page' => $page,
                'sectors' => $sectors,
                'concerns' => $concerns,
                'organizations' => $organizations,
            ],
        ]);
    }

    public function adminIndex()
    {
        $page = WebsiteSisterConcernPage::query()->first();

        if ($page) {
            $page->hero_image_url = $this->imageUrl($page->hero_image);
        }

        $sectors = WebsiteSisterConcernSector::query()
            ->orderBy('sort_order')
            ->get();

        $concerns = WebsiteSisterConcern::query()
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) {
                $item->image_url = $this->imageUrl($item->image);

                return $item;
            });

        $organizations = WebsiteSisterOrganization::query()
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'page' => $page,
                'sectors' => $sectors,
                'concerns' => $concerns,
                'organizations' => $organizations,
            ],
        ]);
    }

    public function updatePage(Request $request)
    {
        $validated = $request->validate([
            'label' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'highlight' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'image', 'max:5120'],
            'status' => ['nullable', 'boolean'],
        ]);

        $page = WebsiteSisterConcernPage::query()->first();

        if (!$page) {
            $page = new WebsiteSisterConcernPage();
        }

        if ($request->hasFile('hero_image')) {
            if ($page->hero_image) {
                Storage::disk('public')->delete($page->hero_image);
            }

            $validated['hero_image'] = $request
                ->file('hero_image')
                ->store('website/sister-concerns', 'public');
        }

        $page->fill($validated);
        $page->save();

        $page->hero_image_url = $this->imageUrl($page->hero_image);

        return response()->json([
            'status' => true,
            'message' => 'Sister concern page updated successfully.',
            'data' => $page,
        ]);
    }

    public function storeSector(Request $request)
    {
        $validated = $request->validate([
            'value' => ['required', 'string', 'max:255'],
            'label' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer'],
            'status' => ['nullable', 'boolean'],
        ]);

        $sector = WebsiteSisterConcernSector::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Sector created successfully.',
            'data' => $sector,
        ]);
    }

    public function updateSector(Request $request, int $id)
    {
        $sector = WebsiteSisterConcernSector::findOrFail($id);

        $validated = $request->validate([
            'value' => ['required', 'string', 'max:255'],
            'label' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer'],
            'status' => ['nullable', 'boolean'],
        ]);

        $sector->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Sector updated successfully.',
            'data' => $sector,
        ]);
    }

    public function deleteSector(int $id)
    {
        WebsiteSisterConcernSector::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sector deleted successfully.',
        ]);
    }

    public function storeConcern(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_title' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'icon' => ['nullable', 'string', 'max:100'],
            'number' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer'],
            'status' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('website/sister-concerns', 'public');
        }

        $concern = WebsiteSisterConcern::create($validated);

        $concern->image_url = $this->imageUrl($concern->image);

        return response()->json([
            'status' => true,
            'message' => 'Sister concern created successfully.',
            'data' => $concern,
        ]);
    }

    public function updateConcern(Request $request, int $id)
    {
        $concern = WebsiteSisterConcern::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_title' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'icon' => ['nullable', 'string', 'max:100'],
            'number' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer'],
            'status' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($concern->image) {
                Storage::disk('public')->delete($concern->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('website/sister-concerns', 'public');
        }

        $concern->update($validated);

        $concern->image_url = $this->imageUrl($concern->image);

        return response()->json([
            'status' => true,
            'message' => 'Sister concern updated successfully.',
            'data' => $concern,
        ]);
    }

    public function deleteConcern(int $id)
    {
        $concern = WebsiteSisterConcern::findOrFail($id);

        if ($concern->image) {
            Storage::disk('public')->delete($concern->image);
        }

        $concern->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sister concern deleted successfully.',
        ]);
    }

    public function storeOrganization(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'function' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer'],
            'status' => ['nullable', 'boolean'],
        ]);

        $organization = WebsiteSisterOrganization::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Sister organization created successfully.',
            'data' => $organization,
        ]);
    }

    public function updateOrganization(Request $request, int $id)
    {
        $organization = WebsiteSisterOrganization::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'function' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer'],
            'status' => ['nullable', 'boolean'],
        ]);

        $organization->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Sister organization updated successfully.',
            'data' => $organization,
        ]);
    }

    public function deleteOrganization(int $id)
    {
        WebsiteSisterOrganization::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sister organization deleted successfully.',
        ]);
    }

    private function imageUrl(?string $image): ?string
    {
        if (!$image) {
            return null;
        }

        if (str_starts_with($image, 'http://') ||
            str_starts_with($image, 'https://')) {
            return $image;
        }

        if (str_starts_with($image, '/images/')) {
            return $image;
        }

        return Storage::disk('public')->url($image);
    }
}