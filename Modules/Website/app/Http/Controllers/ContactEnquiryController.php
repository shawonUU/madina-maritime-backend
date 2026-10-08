<?php

namespace Modules\Website\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Modules\Website\App\Models\WebsiteContactMessage;

class ContactEnquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email:rfc|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:10000',
        ]);

        $contact = WebsiteContactMessage::create($validated);

        $notificationEmail = env(
            'CONTACT_NOTIFICATION_EMAIL',
            config('mail.from.address')
        );

        if ($notificationEmail) {
            try {
                Mail::raw(
                    "A new contact enquiry has been received.\n\n"
                    . "Name: {$contact->name}\n"
                    . "Email: {$contact->email}\n"
                    . "Phone: " . ($contact->phone ?: 'Not provided') . "\n"
                    . "Subject: {$contact->subject}\n\n"
                    . "Message:\n{$contact->message}\n\n"
                    . "Enquiry ID: {$contact->id}",
                    function ($mail) use ($notificationEmail, $contact) {
                        $mail->to($notificationEmail)
                            ->subject('New Website Enquiry: ' . $contact->subject)
                            ->replyTo($contact->email, $contact->name);
                    }
                );
            } catch (\Throwable $e) {
                Log::error('Contact enquiry notification email failed.', [
                    'contact_message_id' => $contact->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Your message has been submitted successfully.',
            'data' => [
                'id' => $contact->id,
            ],
        ], 201);
    }

    public function index(Request $request)
    {
        $query = WebsiteContactMessage::query()
            ->withCount('replies');

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $messages = $query
            ->latest()
            ->paginate(15);

        return response()->json([
            'status' => true,
            'data' => $messages,
            'counts' => [
                'New' => WebsiteContactMessage::where('status', 'New')->count(),
                'Read' => WebsiteContactMessage::where('status', 'Read')->count(),
                'Replied' => WebsiteContactMessage::where('status', 'Replied')->count(),
            ],
        ]);
    }

    public function show($id)
    {
        $contact = WebsiteContactMessage::with([
            'replies' => fn ($query) => $query->latest(),
        ])->findOrFail($id);

        if ($contact->status === 'New') {
            $contact->update([
                'status' => 'Read',
                'read_at' => now(),
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $contact->fresh()->load([
                'replies' => fn ($query) => $query->latest(),
            ]),
        ]);
    }

    public function reply(Request $request, $id)
    {
        $validated = $request->validate([
            'reply_message' => 'required|string|max:20000',
        ]);

        $contact = WebsiteContactMessage::findOrFail($id);

        try {
            Mail::raw(
                $validated['reply_message'],
                function ($mail) use ($contact) {
                    $mail->to($contact->email, $contact->name)
                        ->subject('Re: ' . $contact->subject)
                        ->replyTo(
                            config('mail.from.address'),
                            config('mail.from.name')
                        );
                }
            );
        } catch (\Throwable $e) {
            Log::error('Contact enquiry reply email failed.', [
                'contact_message_id' => $contact->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Email could not be sent. Please check the mail configuration and try again.',
            ], 500);
        }

        $contact->replies()->create([
            'reply_message' => $validated['reply_message'],
            'replied_by' => (string) (
                Auth::user()->email
                ?? Auth::user()->name
                ?? 'Admin'
            ),
            'recipient_email' => $contact->email,
            'sent_at' => now(),
        ]);

        $contact->update([
            'status' => 'Replied',
            'replied_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Reply email sent successfully.',
            'data' => $contact->fresh()->load('replies'),
        ]);
    }

    public function destroy($id)
    {
        $contact = WebsiteContactMessage::findOrFail($id);
        $contact->delete();

        return response()->json([
            'status' => true,
            'message' => 'Contact enquiry deleted successfully.',
        ]);
    }
}