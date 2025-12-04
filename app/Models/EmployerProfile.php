<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class EmployerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_slug',
        'logo',
        'website',
        'phone',
        'address',
        'company_size',
        'about',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'employer_profile_id');
    }
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($profile) {
            if (empty($profile->company_slug)) {
                $profile->company_slug = Str::slug($profile->company_name);
            }
        });
    }
}

