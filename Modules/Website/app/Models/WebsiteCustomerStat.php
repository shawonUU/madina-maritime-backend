<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteCustomerStat extends Model
{
    protected $table = 'website_customer_stats';

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];
}