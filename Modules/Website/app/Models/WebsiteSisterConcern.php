<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSisterConcern extends Model
{
    protected $table = 'website_sister_concerns';

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];
}