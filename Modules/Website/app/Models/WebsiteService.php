<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteService extends Model
{

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];
}