<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_id',
        'evaluator_id',
        'rating',
        'strengths',
        'weaknesses',
        'overall_comment',
    ];

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }
}
