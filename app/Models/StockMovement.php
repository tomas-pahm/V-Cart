<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $table = 'stock_movements';      
    protected $primaryKey = 'stock_movements_id';
    public $incrementing = false;
    protected $keyType = 'int';
    
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'old_stock',
        'new_stock',
        'reason',
        'created_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function scopeIn($query)      { return $query->where('type', 'in'); }
    public function scopeOut($query)     { return $query->where('type', 'out'); }
    public function scopeAdjust($query)  { return $query->where('type', 'adjust'); }

    public function getTypeBadgeAttribute()
    {
        return match ($this->type) {
            'in'     => '<span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Nhập kho</span>',
            'out'    => '<span class="px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">Xuất kho</span>',
            'adjust' => '<span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">Điều chỉnh</span>',
        };
    }
}