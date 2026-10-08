<?php

namespace Modules\Website\App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $table = 'website_contact_settings';

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];
}