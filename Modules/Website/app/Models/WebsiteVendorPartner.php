<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteVendorPartner extends Model
{
    protected $table = 'website_vendors_partners';

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];
}