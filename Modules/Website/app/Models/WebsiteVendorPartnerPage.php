<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteVendorPartnerPage extends Model
{
    protected $table = 'website_vendor_partner_pages';

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];
}