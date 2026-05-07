<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicianProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'speciality',
        'rating',
        'is_available',
        'city',
        'phone',
        'photo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
