<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'amount',
        'method',
        'gateway_transaction_id',
        'status',
        'paid_at',
        'created_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    // -------------------------
    // Relationships
    // -------------------------

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    // -------------------------
    // Helpers
    // -------------------------

    public function isConfirmed()
    {
        return $this->status === 'Confirmed';
    }

    public function isPending()
    {
        return $this->status === 'Pending';
    }

    public function isFailed()
    {
        return $this->status === 'Failed';
    }
}
