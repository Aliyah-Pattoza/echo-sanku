<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'exchange_transaction_id',
        'waste_type_id',
        'quantity',
        'point_per_unit',
        'subtotal_points',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'point_per_unit' => 'decimal:2',
            'subtotal_points' => 'decimal:2',
        ];
    }

    public function transaction()
    {
        return $this->belongsTo(ExchangeTransaction::class, 'exchange_transaction_id');
    }

    public function wasteType()
    {
        return $this->belongsTo(WasteType::class);
    }
}