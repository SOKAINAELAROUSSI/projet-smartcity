<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'image',
        'after_image',
        'latitude',
        'longitude',
        'address',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function rating()
    {
        return $this->hasOne(Rating::class);
    }
}
