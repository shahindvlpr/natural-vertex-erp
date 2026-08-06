<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'website',
        'logo',
        'favicon',
        'signature',
        'vat_number',
        'bin_number',
        'tin_number',
        'tax_zone',
        'currency',
        'currency_symbol',
        'timezone',
        'fiscal_year',
        'fiscal_year_start',
        'fiscal_year_end',
        'invoice_prefix',
        'invoice_start_number',
        'invoice_footer',
        'is_active',
        'maintenance_mode',
        'maintenance_message',
        'facebook',
        'twitter',
        'linkedin',
        'youtube',
    ];

    protected $casts = [
        'fiscal_year_start' => 'date',
        'fiscal_year_end' => 'date',
        'is_active' => 'boolean',
        'maintenance_mode' => 'boolean',
    ];

    // Get logo URL
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/uploads/companies/' . $this->logo);
        }
        return asset('images/default-logo.png');
    }

    // Get favicon URL
    public function getFaviconUrlAttribute()
    {
        if ($this->favicon) {
            return asset('storage/uploads/companies/' . $this->favicon);
        }
        return asset('images/favicon.ico');
    }

    // Get signature URL
    public function getSignatureUrlAttribute()
    {
        if ($this->signature) {
            return asset('storage/uploads/companies/' . $this->signature);
        }
        return null;
    }

    // Get formatted currency
    public function getFormattedCurrencyAttribute()
    {
        return $this->currency_symbol . ' ' . $this->currency;
    }

    // Boot method for creating default settings
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->currency_symbol)) {
                $model->currency_symbol = '৳';
            }
        });
    }
}