<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'avatar',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public const ROLES = [
        'SUPER_ADMIN' => 'Super Admin',
        'ADMIN' => 'Admin',
        'SELLER' => 'Seller',
        'USER' => 'User'
    ];

    public static function booted()
    {
        static::creating(function($model) {
            $model->avatar = asset('/images/avatars/dummy-profile.svg');
        });
    }

    // RELATIONSHIPS

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
