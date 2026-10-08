<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteCareerSetting extends Model
{
    protected $table = 'website_career_settings';

    protected $guarded = [];

    protected $casts = [
        'stats' => 'array',
        'why_benefits' => 'array',
        'status' => 'boolean',
    ];
}