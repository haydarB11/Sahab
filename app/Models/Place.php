<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'image',
        'address',
        'description',
        'weekday_price',
        'weekend_price',
        'tag',
        'category_id',
        'vendor_id',
        'area_id'
    ];

    // protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [

    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($place) {
            $place->placeImages()->delete();
        });
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'place_amenities');
    }

    public function specialDays()
    {
        return $this->hasMany(SpecialDay::class);
        // return $this->hasMany(SpecialDay::class)->onDelete('cascade');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function placeImages()
    {
        return $this->hasMany(PlaceImage::class);
        // return $this->hasMany(PlaceImage::class)->onDelete('cascade');
    }

    public function scopeWithAverageRating($query)
    {
        return $query->selectRaw('places.*, AVG(ratings.rate) as rating')
            ->leftJoin('ratings', 'places.id', '=', 'ratings.place_id')
            ->groupBy('places.id');
    }

    public function availablePlaceAmenities()
    {
        return $this->belongsToMany(Amenity::class, 'place_amenities');
    }

    // public function averageRating()
    // {
    //     return $this->ratings()->selectRaw('AVG(rate) as rating')->groupBy('place_id');
    // }
}
