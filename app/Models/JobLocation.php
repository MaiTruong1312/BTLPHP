<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JobLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'country',
        'slug',
    ];

    protected $attributes = [
        'country' => 'Vietnam',
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class, 'location_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($location) {
            if (empty($location->slug)) {
                $location->slug = Str::slug($location->city);
            }
        });
    }
}

