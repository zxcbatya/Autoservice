<?php

declare(strict_types=1);

namespace App\Models\Sto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoWorker extends Model
{
    protected $table = 'sto_workers';

    protected $fillable = [
        'name',
        'phone',
        'payment_type',
        'rate',
        'is_active',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function orderAssignments(): HasMany
    {
        return $this->hasMany(StoOrderWorker::class, 'worker_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(StoWorkerPayment::class, 'worker_id');
    }

    public function pendingDebt(): float
    {
        return (float) $this->payments()->where('status', 'pending')->sum('amount');
    }
}
