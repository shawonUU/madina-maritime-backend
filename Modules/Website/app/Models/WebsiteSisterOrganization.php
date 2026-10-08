<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSisterOrganization extends Model
{
    protected $table = 'website_sister_organizations';

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];
}