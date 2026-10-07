<?php

namespace Modules\HRM\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Admin\App\Models\User;

class ApplicationStatusHistory extends Model
{
    protected $fillable = [
        'job_application_id',
        'old_status',
        'new_status',
        'note',
        'changed_by',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(
            JobApplication::class,
            'job_application_id'
        );
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'changed_by'
        );
    }
}