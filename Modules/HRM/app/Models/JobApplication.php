<?php

namespace Modules\HRM\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Admin\App\Models\User;
use Modules\HRM\App\Models\RecruitmentEmailLog;

class JobApplication extends Model
{
    protected $guarded = [];

    protected $casts = [
        'expected_salary' => 'decimal:2',
        'shortlisted_at' => 'datetime',
        'interview_at' => 'datetime',
        'selected_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function jobPost(): BelongsTo
    {
        return $this->belongsTo(JobPost::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(ApplicationStatusHistory::class);
    }

    public function emailLogs()
    {
        return $this->hasMany(
            RecruitmentEmailLog::class,
            'job_application_id'
        );
    }
}