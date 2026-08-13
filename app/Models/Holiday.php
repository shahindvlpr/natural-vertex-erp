<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'date',
        'type',
        'description',
        'is_paid',
        'is_active',
    ];

    protected $casts = [
        'date' => 'date',
        'is_paid' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getFormattedDateAttribute()
    {
        return $this->date->format('d M Y');
    }

    public function getDayNameAttribute()
    {
        return $this->date->format('l');
    }
}