<?php

namespace Modules\Website\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Website\App\Models\WebsiteCustomer;
use Modules\Website\App\Models\WebsiteCustomerPage;
use Modules\Website\App\Models\WebsiteCustomerStat;

class WebsiteCustomerController extends Controller
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

    public function index()
    {
        $page = WebsiteCustomerPage::first();

        if (!$page) {
            $page = WebsiteCustomerPage::create([
                'label' => 'Our Customers',
                'title' => 'Trusted by',
                'highlight' => 'industry leaders.',
                'description' => 'We build long-term relationships with organizations that value reliability, operational excellence and dependable maritime solutions.',
                'hero_image' => '/images/ship22.jpg',
                'explore_button_text' => 'Explore Customers',
                'explore_button_url' => '#customers',
                'partner_button_text' => 'Become a Partner',
                'partner_button_url' => '/contact',
                'status' => true,
            ]);
        }

        $stats = WebsiteCustomerStat::where('status', true)
            ->orderBy('sort_order')
            ->get();

        $customers = WebsiteCustomer::where('status', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'page' => [
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
                    'status' => $page->status,
                ],

                'stats' => $stats->map(function ($stat) {
                    return [
                        'id' => $stat->id,
                        'value' => $stat->value,
                        'label' => $stat->label,
                        'icon' => $stat->icon,
                        'sort_order' => $stat->sort_order,
                        'status' => $stat->status,
                    ];
                }),

                'customers' => $customers->map(function ($customer) {
                    return [
                        'id' => $customer->id,
                        'name' => $customer->name,
                        'category' => $customer->category,
                        'logo' => $customer->logo,
                        'logo_url' => $this->mediaUrl($customer->logo),
                        'description' => $customer->description,
                        'sort_order' => $customer->sort_order,
                        'status' => $customer->status,
                    ];
                }),
            ],
        ]);
    }

    public function adminIndex()
    {
        $page = WebsiteCustomerPage::first();

        $stats = WebsiteCustomerStat::orderBy('sort_order')->get();

        $customers = WebsiteCustomer::orderBy('sort_order')
            ->get()
            ->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'category' => $customer->category,
                    'logo' => $customer->logo,
                    'logo_url' => $this->mediaUrl($customer->logo),
                    'description' => $customer->description,
                    'sort_order' => $customer->sort_order,
                    'status' => (bool) $customer->status,
                    'created_at' => $customer->created_at,
                    'updated_at' => $customer->updated_at,
                ];
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

                'customers' => $customers,
            ],
        ]);
    }

    public function updatePage(Request $request)
    {
        $page = WebsiteCustomerPage::first();

        if (!$page) {
            $page = new WebsiteCustomerPage();
        }

        $data = $request->validate([
            'label' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'highlight' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'explore_button_text' => 'nullable|string|max:255',
            'explore_button_url' => 'nullable|string|max:255',
            'partner_button_text' => 'nullable|string|max:255',
            'partner_button_url' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'hero_image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('hero_image')) {
            if (
                $page->hero_image &&
                !str_starts_with($page->hero_image, '/') &&
                Storage::disk('public')->exists($page->hero_image)
            ) {
                Storage::disk('public')->delete($page->hero_image);
            }

            $data['hero_image'] = $request->file('hero_image')
                ->store('website/customers', 'public');
        }

        $page->fill($data);
        $page->save();

        return response()->json([
            'status' => true,
            'message' => 'Customer page updated successfully.',
            'data' => $page,
        ]);
    }

    public function storeStat(Request $request)
    {
        $data = $request->validate([
            'value' => 'required|string|max:100',
            'label' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $stat = WebsiteCustomerStat::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Customer stat created successfully.',
            'data' => $stat,
        ]);
    }

    public function updateStat(Request $request, $id)
    {
        $stat = WebsiteCustomerStat::findOrFail($id);

        $data = $request->validate([
            'value' => 'required|string|max:100',
            'label' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $stat->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Customer stat updated successfully.',
            'data' => $stat,
        ]);
    }

    public function destroyStat($id)
    {
        WebsiteCustomerStat::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Customer stat deleted successfully.',
        ]);
    }

    public function storeCustomer(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'logo' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')
                ->store('website/customers/logos', 'public');
        }

        $customer = WebsiteCustomer::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Customer created successfully.',
            'data' => $customer,
        ]);
    }

    public function updateCustomer(Request $request, $id)
    {
        $customer = WebsiteCustomer::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'logo' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('logo')) {
            if (
                $customer->logo &&
                Storage::disk('public')->exists($customer->logo)
            ) {
                Storage::disk('public')->delete($customer->logo);
            }

            $data['logo'] = $request->file('logo')
                ->store('website/customers/logos', 'public');
        }

        $customer->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Customer updated successfully.',
            'data' => $customer,
        ]);
    }

    public function destroyCustomer($id)
    {
        $customer = WebsiteCustomer::findOrFail($id);

        if (
            $customer->logo &&
            Storage::disk('public')->exists($customer->logo)
        ) {
            Storage::disk('public')->delete($customer->logo);
        }

        $customer->delete();

        return response()->json([
            'status' => true,
            'message' => 'Customer deleted successfully.',
        ]);
    }
}