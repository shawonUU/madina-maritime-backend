<?php

namespace Modules\Website\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Website\App\Models\WebsiteServiceEquipment;
use Modules\Website\App\Models\WebsiteService;
use Modules\Website\App\Models\WebsiteServicePage;
use Modules\Website\App\Models\WebsiteServiceStat;

class MarineServicesController extends Controller
{
    private function mediaUrl(?string $path): ?string
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

        return Storage::disk('public')->url($path);
    }

    public function index()
    {
        $page = WebsiteServicePage::first();

        $stats = WebsiteServiceStat::where('status', true)
            ->orderBy('sort_order')
            ->get();

        $services = WebsiteService::where('status', true)
            ->orderBy('sort_order')
            ->get();

        $equipments = WebsiteServiceEquipment::where('status', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) {
                return array_merge(
                    $item->toArray(),
                    [
                        'image_url' => $this->mediaUrl($item->image),
                    ]
                );
            });

        return response()->json([
            'status' => true,
            'data' => [
                'page' => $page
                    ? array_merge(
                        $page->toArray(),
                        [
                            'hero_image_url' => $this->mediaUrl(
                                $page->hero_image
                            ),
                        ]
                    )
                    : null,

                'stats' => $stats,

                'services' => $services,

                'equipments' => $equipments,
            ],
        ]);
    }

    public function adminIndex()
    {
        $page = WebsiteServicePage::first();

        $stats = WebsiteServiceStat::orderBy('sort_order')
            ->get();

        $services = WebsiteService::orderBy('sort_order')
            ->get();

        $equipments = WebsiteServiceEquipment::orderBy('sort_order')
            ->get()
            ->map(function ($item) {
                return array_merge(
                    $item->toArray(),
                    [
                        'image_url' => $this->mediaUrl($item->image),
                    ]
                );
            });

        return response()->json([
            'status' => true,
            'data' => [
                'page' => $page
                    ? array_merge(
                        $page->toArray(),
                        [
                            'hero_image_url' => $this->mediaUrl(
                                $page->hero_image
                            ),
                        ]
                    )
                    : null,

                'stats' => $stats,

                'services' => $services,

                'equipments' => $equipments,
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
            'status' => ['required'],
            'hero_image' => ['nullable', 'image', 'max:5120'],
        ]);

        $page = WebsiteServicePage::first();

        if (!$page) {
            $page = new WebsiteServicePage();
        }

        $page->label = $validated['label'] ?? null;
        $page->title = $validated['title'] ?? null;
        $page->highlight = $validated['highlight'] ?? null;
        $page->description = $validated['description'] ?? null;
        $page->status = (bool) $request->status;

        if ($request->hasFile('hero_image')) {
            if ($page->hero_image && !str_starts_with($page->hero_image, '/images/')) {
                Storage::disk('public')->delete($page->hero_image);
            }

            $page->hero_image = $request->file('hero_image')
                ->store('website/marine-services', 'public');
        }

        $page->save();

        return response()->json([
            'status' => true,
            'message' => 'Marine services page updated successfully.',
            'data' => $page,
        ]);
    }

    public function storeStat(Request $request)
    {
        $validated = $request->validate([
            'value' => ['required', 'string', 'max:100'],
            'label' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer'],
            'status' => ['required'],
        ]);

        $stat = WebsiteServiceStat::create([
            'value' => $validated['value'],
            'label' => $validated['label'],
            'sort_order' => $validated['sort_order'],
            'status' => (bool) $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Statistic created successfully.',
            'data' => $stat,
        ]);
    }

    public function updateStat(Request $request, int $id)
    {
        $stat = WebsiteServiceStat::findOrFail($id);

        $validated = $request->validate([
            'value' => ['required', 'string', 'max:100'],
            'label' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer'],
            'status' => ['required'],
        ]);

        $stat->update([
            'value' => $validated['value'],
            'label' => $validated['label'],
            'sort_order' => $validated['sort_order'],
            'status' => (bool) $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Statistic updated successfully.',
            'data' => $stat,
        ]);
    }

    public function deleteStat(int $id)
    {
        WebsiteServiceStat::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Statistic deleted successfully.',
        ]);
    }

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'number' => ['required', 'string', 'max:20'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['required', 'string', 'max:100'],
            'sort_order' => ['required', 'integer'],
            'status' => ['required'],
        ]);

        $service = WebsiteService::create([
            'number' => $validated['number'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'icon' => $validated['icon'],
            'sort_order' => $validated['sort_order'],
            'status' => (bool) $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Service created successfully.',
            'data' => $service,
        ]);
    }

    public function updateService(Request $request, int $id)
    {
        $service = WebsiteService::findOrFail($id);

        $validated = $request->validate([
            'number' => ['required', 'string', 'max:20'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['required', 'string', 'max:100'],
            'sort_order' => ['required', 'integer'],
            'status' => ['required'],
        ]);

        $service->update([
            'number' => $validated['number'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'icon' => $validated['icon'],
            'sort_order' => $validated['sort_order'],
            'status' => (bool) $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Service updated successfully.',
            'data' => $service,
        ]);
    }

    public function deleteService(int $id)
    {
        WebsiteService::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Service deleted successfully.',
        ]);
    }

    public function storeEquipment(Request $request)
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'units' => ['nullable', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'sort_order' => ['required', 'integer'],
            'status' => ['required'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $equipment = WebsiteServiceEquipment::create([
            'category' => $validated['category'],
            'name' => $validated['name'],
            'units' => $validated['units'] ?? null,
            'description' => $validated['description'],
            'sort_order' => $validated['sort_order'],
            'status' => (bool) $request->status,
        ]);

        if ($request->hasFile('image')) {
            $equipment->image = $request->file('image')
                ->store('website/marine-equipment', 'public');

            $equipment->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Equipment created successfully.',
            'data' => $equipment,
        ]);
    }

    public function updateEquipment(Request $request, int $id)
    {
        $equipment = WebsiteServiceEquipment::findOrFail($id);

        $validated = $request->validate([
            'category' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'units' => ['nullable', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'sort_order' => ['required', 'integer'],
            'status' => ['required'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $equipment->update([
            'category' => $validated['category'],
            'name' => $validated['name'],
            'units' => $validated['units'] ?? null,
            'description' => $validated['description'],
            'sort_order' => $validated['sort_order'],
            'status' => (bool) $request->status,
        ]);

        if ($request->hasFile('image')) {
            if ($equipment->image && !str_starts_with($equipment->image, '/images/')) {
                Storage::disk('public')->delete($equipment->image);
            }

            $equipment->image = $request->file('image')
                ->store('website/marine-equipment', 'public');

            $equipment->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Equipment updated successfully.',
            'data' => $equipment,
        ]);
    }

    public function deleteEquipment(int $id)
    {
        $equipment = WebsiteServiceEquipment::findOrFail($id);

        if ($equipment->image && !str_starts_with($equipment->image, '/images/')) {
            Storage::disk('public')->delete($equipment->image);
        }

        $equipment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Equipment deleted successfully.',
        ]);
    }
}