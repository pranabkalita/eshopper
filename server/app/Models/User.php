<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
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

    public const DEFAULT_USER_PASSWORD = 'password';
    public const AVATAR_PATH = '/images/avatars/';

    public static function booted()
    {
        static::creating(function($model) {
            $model->avatar = asset('/images/avatars/dummy-profile.svg');
            $model->password = Hash::make($model->password);
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

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // METHODS

    public function generateAvatarName($avatar)
    {
        return $this->first_name . '-' . Str::random(10) . '-' . now() . '.' . $avatar->getClientOriginalExtension();
    }
}
