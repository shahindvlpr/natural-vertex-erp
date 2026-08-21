<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id', 
        'product_id', 
        'rack_id', 
        'type', 
        'quantity', 
        'stock_before', 
        'stock_after', 
        'movement_date', 
        'reference', 
        'created_by'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function rack()
    {
        return $this->belongsTo(Rack::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}