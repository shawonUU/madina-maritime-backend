<?php

namespace Modules\Website\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Website\App\Models\WebsiteAboutStat;

class WebsiteAboutStatController extends Controller
{
    public function index()
    {
        $stats = WebsiteAboutStat::where('status', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $stats,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $stat = WebsiteAboutStat::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Statistic created successfully.',
            'data' => $stat,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $stat = WebsiteAboutStat::findOrFail($id);

        $validated = $request->validate([
            'value' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $stat->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Statistic updated successfully.',
            'data' => $stat,
        ]);
    }

    public function destroy($id)
    {
        $stat = WebsiteAboutStat::findOrFail($id);

        $stat->delete();

        return response()->json([
            'status' => true,
            'message' => 'Statistic deleted successfully.',
        ]);
    }
}