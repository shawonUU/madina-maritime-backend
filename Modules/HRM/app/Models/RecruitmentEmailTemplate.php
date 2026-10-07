<?php

namespace Modules\HRM\App\Models;

use Illuminate\Database\Eloquent\Model;

class RecruitmentEmailTemplate extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}