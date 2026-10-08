<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteAbout extends Model
{
    protected $guarded = [];

    protected $casts = [
        'milestones' => 'array',
        'tonnage' => 'array',
        'status' => 'boolean',
    ];
}