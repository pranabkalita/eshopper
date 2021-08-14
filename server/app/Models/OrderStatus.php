<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    // RELATIONSHIP

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
