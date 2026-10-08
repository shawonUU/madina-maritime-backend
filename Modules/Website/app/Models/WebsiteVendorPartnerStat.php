<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteVendorPartnerStat extends Model
{
    protected $table = 'website_vendor_partner_stats';

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];
}