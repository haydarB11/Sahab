<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PlaceImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'place_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [

    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($placeImage) {
            Storage::delete(str_replace('storage/', 'public/', $placeImage->image));
        });
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
