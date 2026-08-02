<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public const TYPES = ['project', 'cohort', 'mentorship', 'course'];

    public const STATUSES = ['new', 'contacted', 'closed'];

    protected $guarded = [];

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            'cohort' => 'Cohort enrolment',
            'mentorship' => '1-on-1 mentorship',
            'course' => 'Skill course',
            default => 'Project enquiry',
        };
    }
}
