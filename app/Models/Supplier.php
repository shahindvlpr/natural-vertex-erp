<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'address',
        'contact_person',
        'contact_phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function purchaseInvoices()
    {
        return $this->hasMany(PurchaseInvoice::class);
    }

    public function getTotalPurchasesAttribute()
    {
        return $this->purchaseOrders()->sum('total_amount');
    }

    public function getTotalPaidAttribute()
    {
        return $this->purchaseInvoices()->sum('paid_amount');
    }

    public function getTotalDueAttribute()
    {
        return $this->purchaseInvoices()->sum('due_amount');
    }

    public function getPurchaseCountAttribute()
    {
        return $this->purchaseOrders()->count();
    }
}