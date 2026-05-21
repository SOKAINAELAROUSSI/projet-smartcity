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
        'photo',
        'availability_status',
        'notif_new_mission',
        'notif_admin_messages',
        'notif_urgent_missions',
        'theme',
        'language'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
