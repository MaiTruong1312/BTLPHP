<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id',
        'user_id',
        'from_status',
        'to_status',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
