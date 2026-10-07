<?php

namespace Modules\HRM\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPost extends Model
{
    protected $guarded = [];

    protected $casts = [
        'application_deadline' => 'date',
        'is_featured' => 'boolean',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}