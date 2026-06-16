<?php

declare(strict_types=1);

namespace App\Models\Sto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoWorkerPayment extends Model
{
    protected $table = 'sto_worker_payments';

    protected $fillable = [
        'worker_id',
        'order_id',
        'amount',
        'paid_at',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'date',
    ];

    public function worker(): BelongsTo
    {
        return $this->belongsTo(StoWorker::class, 'worker_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(StoOrder::class, 'order_id');
    }
}
