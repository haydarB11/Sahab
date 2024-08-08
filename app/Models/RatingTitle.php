<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingTitle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [

    ];

    // public function ratingMessages()
    // {
    //     return $this->hasMany(RatingMessage::class);
    // }

}
