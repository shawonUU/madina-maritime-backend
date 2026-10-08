<?php

namespace Modules\Website\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Website\App\Models\WebsiteVendorPartner;
use Modules\Website\App\Models\WebsiteVendorPartnerPage;
use Modules\Website\App\Models\WebsiteVendorPartnerStat;

class VendorPartnerController extends Controller
{
    private function mediaUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (
            str_starts_with($path, 'http://') ||
            str_starts_with($path, 'https://')
        ) {
            return $path;
        }

        if (str_starts_with($path, '/images/')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return '/' . $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    private function customerData($partner): array
    {
        return [
            'id' => $partner->id,
            'name' => $partner->name,
            'category' => $partner->category,
            'logo' => $partner->logo,
            'logo_url' => $this->mediaUrl($partner->logo),
            'description' => $partner->description,
            'sort_order' => $partner->sort_order,
            'status' => (bool) $partner->status,
            'created_at' => $partner->created_at,
            'updated_at' => $partner->updated_at,
        ];
    }

    public function index()
    {
        $page = WebsiteVendorPartnerPage::first();

        $stats = WebsiteVendorPartnerStat::where('status', true)
            ->orderBy('sort_order')
            ->get();

        $partners = WebsiteVendorPartner::where('status', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($partner) {
                return $this->customerData($partner);
            });

        return response()->json([
            'status' => true,
            'data' => [
                'page' => $page ? [
                    'id' => $page->id,
                    'label' => $page->label,
                    'title' => $page->title,
                    'highlight' => $page->highlight,
                    'description' => $page->description,
                    'hero_image' => $page->hero_image,
                    'hero_image_url' => $this->mediaUrl($page->hero_image),
                    'explore_button_text' => $page->explore_button_text,
                    'explore_button_url' => $page->explore_button_url,
                    'partner_button_text' => $page->partner_button_text,
                    'partner_button_url' => $page->partner_button_url,
                    'status' => (bool) $page->status,
                ] : null,

                'stats' => $stats,

                'partners' => $partners,
            ],
        ]);
    }

    public function adminIndex()
    {
        $page = WebsiteVendorPartnerPage::first();

        $stats = WebsiteVendorPartnerStat::orderBy('sort_order')->get();

        $partners = WebsiteVendorPartner::orderBy('sort_order')
            ->get()
            ->map(function ($partner) {
                return $this->customerData($partner);
            });

        return response()->json([
            'status' => true,
            'data' => [
                'page' => $page ? [
                    'id' => $page->id,
                    'label' => $page->label,
                    'title' => $page->title,
                    'highlight' => $page->highlight,
                    'description' => $page->description,
                    'hero_image' => $page->hero_image,
                    'hero_image_url' => $this->mediaUrl($page->hero_image),
                    'explore_button_text' => $page->explore_button_text,
                    'explore_button_url' => $page->explore_button_url,
                    'partner_button_text' => $page->partner_button_text,
                    'partner_button_url' => $page->partner_button_url,
                    'status' => (bool) $page->status,
                ] : null,

                'stats' => $stats,

                'partners' => $partners,
            ],
        ]);
    }

    public function updatePage(Request $request)
    {
        $request->validate([
            'label' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'highlight' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'explore_button_text' => 'nullable|string|max:255',
            'explore_button_url' => 'nullable|string|max:255',
            'partner_button_text' => 'nullable|string|max:255',
            'partner_button_url' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        $page = WebsiteVendorPartnerPage::first();

        if (!$page) {
            $page = new WebsiteVendorPartnerPage();
        }

        $page->label = $request->label;
        $page->title = $request->title;
        $page->highlight = $request->highlight;
        $page->description = $request->description;
        $page->explore_button_text = $request->explore_button_text;
        $page->explore_button_url = $request->explore_button_url;
        $page->partner_button_text = $request->partner_button_text;
        $page->partner_button_url = $request->partner_button_url;

        if ($request->has('status')) {
            $page->status = $request->boolean('status');
        }

        if ($request->hasFile('hero_image')) {
            $page->hero_image = $request->file('hero_image')
                ->store('website/vendors-partners', 'public');
        }

        $page->save();

        return response()->json([
            'status' => true,
            'message' => 'Vendor and partner page updated successfully.',
            'data' => $page,
        ]);
    }

    public function storeStat(Request $request)
    {
        $request->validate([
            'value' => 'required|string|max:100',
            'label' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $stat = WebsiteVendorPartnerStat::create([
            'value' => $request->value,
            'label' => $request->label,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->boolean('status', true),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Statistic created successfully.',
            'data' => $stat,
        ]);
    }

    public function updateStat(Request $request, $id)
    {
        $request->validate([
            'value' => 'required|string|max:100',
            'label' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $stat = WebsiteVendorPartnerStat::findOrFail($id);

        $stat->update([
            'value' => $request->value,
            'label' => $request->label,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->boolean('status'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Statistic updated successfully.',
            'data' => $stat,
        ]);
    }

    public function destroyStat($id)
    {
        $stat = WebsiteVendorPartnerStat::findOrFail($id);

        $stat->delete();

        return response()->json([
            'status' => true,
            'message' => 'Statistic deleted successfully.',
        ]);
    }

    public function storePartner(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:5120',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $logo = null;

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo')
                ->store('website/vendors-partners/logos', 'public');
        }

        $partner = WebsiteVendorPartner::create([
            'name' => $request->name,
            'category' => $request->category,
            'logo' => $logo,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->boolean('status', true),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Vendor/Partner created successfully.',
            'data' => $this->customerData($partner),
        ]);
    }

    public function updatePartner(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:5120',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $partner = WebsiteVendorPartner::findOrFail($id);

        $partner->name = $request->name;
        $partner->category = $request->category;
        $partner->description = $request->description;
        $partner->sort_order = $request->sort_order ?? 0;
        $partner->status = $request->boolean('status');

        if ($request->hasFile('logo')) {
            $partner->logo = $request->file('logo')
                ->store('website/vendors-partners/logos', 'public');
        }

        $partner->save();

        return response()->json([
            'status' => true,
            'message' => 'Vendor/Partner updated successfully.',
            'data' => $this->customerData($partner),
        ]);
    }

    public function destroyPartner($id)
    {
        $partner = WebsiteVendorPartner::findOrFail($id);

        $partner->delete();

        return response()->json([
            'status' => true,
            'message' => 'Vendor/Partner deleted successfully.',
        ]);
    }
}