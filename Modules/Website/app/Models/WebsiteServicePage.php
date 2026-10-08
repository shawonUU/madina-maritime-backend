<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteServicePage extends Model
{

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];
}