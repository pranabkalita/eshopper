<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public static function booted()
    {
        static::creating(function($model) {
            $model->total = $model->quantity * $model->price;
        });

        static::updating(function($model) {
            $model->total = $model->quantity * $model->price;
        });
    }

    // RELATIONSHIPS

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // MUTATOR

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = $value * 100;
    }

    // ACCESSORS

    public function getPriceAttribute($value)
    {
        return $value / 100;
    }

    public function getTotalAttribute($value)
    {
        return $value / 100;
    }
}
