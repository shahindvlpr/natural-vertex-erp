<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 
        'location', 
        'manager_name', 
        'phone', 
        'is_active'
    ];

    public function racks()
    {
        return $this->hasMany(Rack::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function fromTransfers()
    {
        return $this->hasMany(StockTransfer::class, 'from_warehouse_id');
    }

    public function toTransfers()
    {
        return $this->hasMany(StockTransfer::class, 'to_warehouse_id');
    }
}