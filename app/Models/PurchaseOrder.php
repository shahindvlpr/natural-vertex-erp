<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'purchase_request_id',
        'supplier_id',
        'order_date',
        'delivery_date',
        'shipping_address',
        'billing_address',
        'sub_total',
        'discount',
        'tax',
        'shipping_charge',
        'total_amount',
        'status',
        'terms_conditions',
        'remarks',
        'created_by',
        'approved_by',
    ];

    protected $casts = [
        'order_date' => 'date',
        'delivery_date' => 'date',
        'sub_total' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping_charge' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function goodsReceives()
    {
        return $this->hasMany(GoodsReceive::class);
    }

    public function invoices()
    {
        return $this->hasMany(PurchaseInvoice::class);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => 'secondary',
            'sent' => 'info',
            'confirmed' => 'success',
            'received' => 'primary',
            'cancelled' => 'danger',
        ];
        return $badges[$this->status] ?? 'secondary';
    }
}