<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteCustomerPage extends Model
{
    protected $table = 'website_customer_pages';

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];
}