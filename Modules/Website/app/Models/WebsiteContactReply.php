<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebsiteContactReply extends Model
{
    protected $table = 'website_contact_replies';

    protected $guarded = [];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function contactMessage(): BelongsTo
    {
        return $this->belongsTo(
            WebsiteContactMessage::class,
            'contact_message_id'
        );
    }
}