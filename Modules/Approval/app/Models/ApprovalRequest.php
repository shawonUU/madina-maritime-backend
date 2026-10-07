<?php

namespace Modules\Approval\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Admin\App\Models\User;
use Modules\Approval\App\Models\ApprovalAction;
use Modules\Approval\App\Models\ApprovalRequestLevel;
use Modules\Approval\App\Models\ApprovalWorkflow;


class ApprovalRequest extends Model
{
    protected $guarded = [];
    
    protected $casts = [
        'submitted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(
            ApprovalWorkflow::class,
            'workflow_id'
        );
    }

    public function levels(): HasMany
    {
        return $this->hasMany(
            ApprovalRequestLevel::class
        )->orderBy('level_no');
    }

    public function actions(): HasMany
    {
        return $this->hasMany(
            ApprovalAction::class
        )->latest();
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'requested_by'
        );
    }
}
