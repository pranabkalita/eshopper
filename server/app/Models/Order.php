<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // RELATIONSHIP

    public function orderStatuses()
    {
        return $this->hasMany(OrderStatus::class);
    }
}
