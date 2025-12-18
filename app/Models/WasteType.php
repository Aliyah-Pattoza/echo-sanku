<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit',
        'point_per_unit',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'point_per_unit' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function exchangeItems()
    {
        return $this->hasMany(ExchangeItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}