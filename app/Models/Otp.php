<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expires_at',
        'otp',
        'phone'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
