<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSisterConcernPage extends Model
{
    protected $table = 'website_sister_concern_pages';

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];
}