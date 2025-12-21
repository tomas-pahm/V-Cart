<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'orderdetail';
    protected $primaryKey = 'order_detail_id';

    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price'
    ];

     // Quan hệ sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // Quan hệ đơn hàng (nên có luôn)
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
