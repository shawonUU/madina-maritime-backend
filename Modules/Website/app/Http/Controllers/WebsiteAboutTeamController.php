<?php

namespace Modules\Website\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Website\App\Models\WebsiteAboutTeam;

class WebsiteAboutTeamController extends Controller
{
    public function index()
    {
        $team = WebsiteAboutTeam::where('status', true)
            ->orderBy('category')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(function ($member) {
                if ($member->image) {
                    $member->image = asset('storage/' . $member->image);
                }

                return $member;
            });

        return response()->json([
            'status' => true,
            'data' => $team,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'category' => 'required|in:management,leadership',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('website/team', 'public');
        }

        $member = WebsiteAboutTeam::create($validated);

        if ($member->image) {
            $member->image = asset('storage/' . $member->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'Team member created successfully.',
            'data' => $member,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $member = WebsiteAboutTeam::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'category' => 'required|in:management,leadership',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if (
                $member->image &&
                Storage::disk('public')->exists($member->image)
            ) {
                Storage::disk('public')->delete($member->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('website/team', 'public');
        }

        $member->update($validated);

        $member->refresh();

        if ($member->image) {
            $member->image = asset('storage/' . $member->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'Team member updated successfully.',
            'data' => $member,
        ]);
    }

    public function destroy($id)
    {
        $member = WebsiteAboutTeam::findOrFail($id);

        if (
            $member->image &&
            Storage::disk('public')->exists($member->image)
        ) {
            Storage::disk('public')->delete($member->image);
        }

        $member->delete();

        return response()->json([
            'status' => true,
            'message' => 'Team member deleted successfully.',
        ]);
    }
}