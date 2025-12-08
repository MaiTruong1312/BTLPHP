<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'subject',
        'body',
        'type',
    ];

    /**
     * Get the user that owns the email template.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
