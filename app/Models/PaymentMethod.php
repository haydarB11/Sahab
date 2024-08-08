<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method',
        'payment_method_id',
        'service_charge',
        'photo'
    ];

    protected $hidden = [
        // 'created_at',
        'updated_at'
    ];

    protected $casts = [

    ];
}
