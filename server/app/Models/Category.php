<?php

namespace App\Models;

use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'isPublished'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function booted()
    {
        static::creating(function($model) {
            $model->slug = Str::slug($model->name);
        });

        static::updating(function($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    // RELATIONSHIPS

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
