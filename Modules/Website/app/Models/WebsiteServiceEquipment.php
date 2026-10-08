<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteServiceEquipment extends Model
{
    protected $table = 'website_service_equipments';
    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];
}