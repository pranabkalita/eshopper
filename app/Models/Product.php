<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public function getRouteKeyName()
    {
        return 'name';
    }

    public static function booted() {
        static::creating(function($model) {
            $model->sku = Str::uuid();
            $model->slug = Str::slug($model->name);
        });
    }

    // MUTATORS

    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = Str::slug($value))->exists()) {
            $slug = $this->incrementSlug($slug);
        }

        $this->attributes['slug'] = $slug;
    }

    // SCOPES

    public function scopeIsLive(Builder $query)
    {
        return $query->where('isPublished', true);
    }

    // METHODS

    public function incrementSlug($slug)
    {
        $originalSlug = $slug;

        $count = 2;

        while(static::whereSlug($slug)->exists()) {
            $slug = "${originalSlug}-" . $count++;
        }

        return $slug;
    }

    // RELATIONSHIPS

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
