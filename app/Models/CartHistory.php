<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartHistory extends Model
{
    protected $table = 'cart_history';
    protected $primaryKey = 'history_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
