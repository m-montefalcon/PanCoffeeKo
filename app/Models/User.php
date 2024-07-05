<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'contact_number',
        'isEmployed',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    //Query all users where currently employed, order by name ascending, paginate by 15
    public function scopeGetUsers($query, $perPage = 15)
    {
        return $query->select('id', 'name', 'role')
            ->where('isEmployed', true)
            ->orderBy('name', 'asc')
            ->paginate($perPage);
    }
    
    public function scopeUserFullDetails($query, $id){
        return $query->select('name', 'email', 'contact_number', 'image_url', 'isEmployed', 'role', 'created_at', 'updated_at')
            ->where('id', $id)
            ->first();
    }

}
