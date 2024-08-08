<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    const DELETED_AT = 'deleted_at';
    
    protected $fillable = [
        'title',
        'image',
        'description',
        'notice_period',
        'duration',
        'price',
        'featured',
        'max_capacity',
        'available',
        'bookable',
        'category_id',
        'vendor_id'
    ];

    // protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [

    ];

    public function availableTimes()
    {
        return $this->hasMany(ServiceAvailableTime::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function serviceImages()
    {
        return $this->hasMany(ServiceImage::class);
        // return $this->hasMany(ServiceImage::class)->onDelete('cascade');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function averageRating()
    {
        return $this->ratings()->selectRaw('AVG(rate) as rating')->groupBy('service_id');
    }

}
