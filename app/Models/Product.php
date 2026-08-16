<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'barcode',
        'sku',
        'category_id',
        'brand_id',
        'unit_id',
        'product_type',
        'purchase_price',
        'selling_price',
        'wholesale_price',
        'min_stock',
        'max_stock',
        'description',
        'image',
        'is_active',
        'is_manufactured',
        'has_expiry',
        'warranty_period',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_manufactured' => 'boolean',
        'has_expiry' => 'boolean',
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function getTotalStockAttribute()
    {
        return $this->stocks()->sum('quantity');
    }

    public function getAvailableStockAttribute()
    {
        return $this->stocks()->sum('available_quantity');
    }
}