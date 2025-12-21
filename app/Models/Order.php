<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id', 'total_amount', 'receiver_name', 'receiver_phone',
        'shipping_address', 'note', 'payment_method', 'payment_status',
        'order_status'
    ];

   public function items()
{
    return $this->hasMany(OrderDetail::class, 'order_id');
}

   public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'user_id');
}

public function payment()
{
    return $this->hasOne(Payment::class, 'order_id', 'order_id');
}

public function isCOD()
{
    return trim(strtolower($this->payment_method)) === 'cod';
}


}