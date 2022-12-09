<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    const HOURLY = 0;
    const DAILY = 1;
    const WEEKLY = 2;
    const MONTHLY = 3;
    const YEARLY = 4;
    const FIXED = 5;

    protected $guarded = [];

    protected $casts =[
        'faq' => 'array',
        'video' => 'array',
        'gallery_image' => 'array'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->where('user_type',2);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
