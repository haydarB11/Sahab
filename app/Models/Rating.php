<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate',
        'user_id',
        // 'service_id',
        // 'place_id',
        'booking_id',
        'title_id',
        'message_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [

    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // public function place()
    // {
    //     return $this->belongsTo(Place::class);
    // }

    // public function service()
    // {
    //     return $this->belongsTo(Service::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratingTitle()
    {
        return $this->belongsTo(RatingTitle::class);
    }

    public function ratingMessage()
    {
        return $this->belongsTo(RatingMessage::class);
    }

}
