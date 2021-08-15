<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

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
}
