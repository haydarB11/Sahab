<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'title_ar', 'icon', 'type'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [

    ];

    public function places()
    {
        return $this->hasMany(Place::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

}
