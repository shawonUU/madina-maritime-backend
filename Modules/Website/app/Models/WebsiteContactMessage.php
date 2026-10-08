<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Website\App\Models\WebsiteContactReply;

class WebsiteContactMessage extends Model
{
    protected $table = 'website_contact_messages';

    protected $guarded = [];

    protected $casts = [
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    public function replies(): HasMany
    {
        return $this->hasMany(WebsiteContactReply::class, 'contact_message_id');
    }
}