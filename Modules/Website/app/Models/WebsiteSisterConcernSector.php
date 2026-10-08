<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSisterConcernSector extends Model
{
    protected $table = 'website_sister_concern_sectors';

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];
}