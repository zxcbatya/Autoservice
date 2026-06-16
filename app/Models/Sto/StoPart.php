<?php

declare(strict_types=1);

namespace App\Models\Sto;

use Illuminate\Database\Eloquent\Model;

class StoPart extends Model
{
    protected $table = 'sto_parts';

    protected $fillable = [
        'name',
        'article',
        'quantity',
        'price',
        'min_quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'min_quantity' => 'integer',
    ];

    public function isLowStock(): bool
    {
        return $this->quantity <= $this->min_quantity;
    }
}
