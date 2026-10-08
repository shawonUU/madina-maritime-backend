<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteHomeSetting extends Model
{
    protected $table = 'website_home_settings';

    protected $guarded = [];

    protected $casts = [
        'stats' => 'array',
        'about_points' => 'array',
        'philosophy_items' => 'array',
        'business_divisions' => 'array',
        'why_items' => 'array',
        'status' => 'boolean',
    ];
}