<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id',
        'interviewer_id',
        'scheduled_at',
        'duration_minutes',
        'type',
        'location',
        'notes',
        'cancellation_reason',
        'status'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }

    public function interviewer()
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }

    public function evaluation()
    {
        return $this->hasOne(InterviewEvaluation::class);
    }
}