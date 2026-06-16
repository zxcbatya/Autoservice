<?php

declare(strict_types=1);

namespace App\Models\Sto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoOrder extends Model
{
    protected $table = 'sto_orders';

    protected $fillable = [
        'number',
        'client_id',
        'service',
        'amount',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public const STATUSES = [
        'new' => 'Новый',
        'in_progress' => 'В работе',
        'ready' => 'Готов',
        'completed' => 'Завершён',
        'cancelled' => 'Отменён',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(StoClient::class, 'client_id');
    }

    public function workers(): HasMany
    {
        return $this->hasMany(StoOrderWorker::class, 'order_id');
    }

    public function workerPayments(): HasMany
    {
        return $this->hasMany(StoWorkerPayment::class, 'order_id');
    }
}
