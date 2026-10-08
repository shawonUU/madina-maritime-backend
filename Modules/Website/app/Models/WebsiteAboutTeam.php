<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteAboutTeam extends Model
{

    protected $guarded = [];

    protected $casts = [
        'sort_order' => 'integer',
        'status' => 'boolean',
    ];
}