<?php

namespace Modules\Website\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Website\App\Models\ContactSetting;

class ContactController extends Controller
{
    private function mediaUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    private function getSettings(): ContactSetting
    {
        return ContactSetting::firstOrCreate(
            ['id' => 1],
            [
                'hero_label' => 'Madina Maritime Limited',
                'hero_title' => "Let's start a",
                'hero_highlight' => 'conversation.',
                'hero_description' => 'Whether you need marine services, business information or want to explore a partnership, our team is ready to hear from you.',
                'hero_image' => 'images/Picture4.png',
                'hero_button_text' => 'Send an Enquiry',
                'hero_button_url' => '#contact-form',
                'bottom_caption' => 'Connecting Through The Sea',
                'address_label' => 'Visit Us',
                'office_title' => 'Head Office',
                'address' => 'Madina Square, 64/A Shahid Buddhijibi Monir Chowdhury Sharak (Central Road), Dhaka-1205, Bangladesh',
                'phone_label' => 'Call Us',
                'phone_title' => 'Office: 88 (0222) 3363531, 3368840 Ext: 385, HP: +8801730-702927',
                'phone_description' => 'Our team is available to assist you.',
                'email_label' => 'Email Us',
                'email' => 'operation.head@madina.co',
                'hours_label' => 'Working Hours',
                'working_days' => 'Sunday – Thursday',
                'working_hours' => '9:00 AM – 6:00 PM',
                'form_label' => 'Send a Message',
                'form_title' => 'Tell us how we can help.',
                'form_description' => 'Fill out the form below and our team will respond as soon as possible.',
                'map_title' => 'Our Location',
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.1452292133567!2d90.38259497440747!3d23.742199989092896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8b9cc54b1df%3A0x6cc23cb4676be16a!2sMadina%20Group!5e0!3m2!1sen!2sbd!4v1786536774398!5m2!1sen!2sbd',
                'status' => true,
            ]
        );
    }

    public function show()
    {
        $contact = $this->getSettings();

        if (!$contact->status) {
            return response()->json([
                'status' => false,
                'message' => 'Contact page is currently unavailable.',
            ], 404);
        }

        $data = $contact->toArray();
        $data['hero_image_url'] = $this->mediaUrl($contact->hero_image);

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    public function adminIndex()
    {
        $contact = $this->getSettings();

        $data = $contact->toArray();
        $data['hero_image_url'] = $this->mediaUrl($contact->hero_image);

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    public function update(Request $request)
    {
        $contact = $this->getSettings();

        $validated = $request->validate([
            'hero_label' => 'nullable|string|max:255',
            'hero_title' => 'required|string|max:255',
            'hero_highlight' => 'required|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'hero_button_text' => 'nullable|string|max:255',
            'hero_button_url' => 'nullable|string|max:255',
            'bottom_caption' => 'nullable|string|max:255',

            'address_label' => 'nullable|string|max:255',
            'office_title' => 'nullable|string|max:255',
            'address' => 'nullable|string',

            'phone_label' => 'nullable|string|max:255',
            'phone_title' => 'nullable|string',
            'phone_description' => 'nullable|string',

            'email_label' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',

            'hours_label' => 'nullable|string|max:255',
            'working_days' => 'nullable|string|max:255',
            'working_hours' => 'nullable|string|max:255',

            'form_label' => 'nullable|string|max:255',
            'form_title' => 'nullable|string|max:255',
            'form_description' => 'nullable|string',

            'map_title' => 'nullable|string|max:255',
            'map_embed_url' => 'nullable|url|max:2000',

            'status' => 'required|boolean',
        ]);

        unset($validated['hero_image']);

        if ($request->hasFile('hero_image')) {
            if (
                $contact->hero_image &&
                !str_starts_with($contact->hero_image, 'http://') &&
                !str_starts_with($contact->hero_image, 'https://') &&
                !str_starts_with($contact->hero_image, '/')
            ) {
                Storage::disk('public')->delete($contact->hero_image);
            }

            $validated['hero_image'] = $request->file('hero_image')
                ->store('website/contact', 'public');
        }

        $contact->update($validated);

        $data = $contact->fresh()->toArray();
        $data['hero_image_url'] = $this->mediaUrl($contact->fresh()->hero_image);

        return response()->json([
            'status' => true,
            'message' => 'Contact page updated successfully.',
            'data' => $data,
        ]);
    }
}