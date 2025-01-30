<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function product_size()
    {
        return $this->belongsTo(ProductSize::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
