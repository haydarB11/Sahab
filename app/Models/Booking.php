<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'starting_date',
        'ending_date',
        // 'payment_method',
        'address', // known what about it
        'total_price',
        'payment',
        'transaction_id',
        'reference_id',
        'invoice_reference',
        'status',
        'place_id',
        'service_id',
        'user_id',
        'payment_method_id',
    ];

    protected $hidden = [
        // 'created_at',
        'updated_at',
    ];

    protected $casts = [

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

}
