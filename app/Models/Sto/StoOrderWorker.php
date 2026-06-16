<?php

declare(strict_types=1);

namespace App\Models\Sto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoOrderWorker extends Model
{
    protected $table = 'sto_order_workers';

    protected $fillable = [
        'order_id',
        'worker_id',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(StoOrder::class, 'order_id');
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(StoWorker::class, 'worker_id');
    }
}
