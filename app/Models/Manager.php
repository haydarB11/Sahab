<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Manager extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable, HasRoles;
    protected $table = 'managers';
    protected $guard = 'admin';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'fcm_token',
    ];

    protected $hidden = ['created_at', 'updated_at', 'password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected function getDefaultGuardName(): string { return 'admin'; }
}
