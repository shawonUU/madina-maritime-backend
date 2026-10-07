<?php

namespace Modules\HRM\App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplicationStatusHistory extends Model
{
    protected$guarded = [];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}