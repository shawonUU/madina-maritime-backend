<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;
class WebsiteHomePage extends Model
{

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];
}