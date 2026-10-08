<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteCustomer extends Model
{
    protected $table = 'website_customers';

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];
}