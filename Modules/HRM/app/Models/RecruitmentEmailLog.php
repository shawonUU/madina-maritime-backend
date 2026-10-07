<?php

namespace Modules\HRM\App\Models;

use Illuminate\Database\Eloquent\Model;

class RecruitmentEmailLog extends Model
{
    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
        'sent_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(JobApplication::class, 'job_application_id');
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    public function template()
    {
        return $this->belongsTo(
            RecruitmentEmailTemplate::class,
            'template_id'
        );
    }
}