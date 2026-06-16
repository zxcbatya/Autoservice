<?php

declare(strict_types=1);

namespace App\Services\Sto;

use App\Models\Sto\StoWorker;
use App\Models\Sto\StoWorkerPayment;
use Illuminate\Support\Facades\DB;

class StoPaymentService
{
    public function payWorker(StoWorker $worker): int
    {
        return DB::transaction(function () use ($worker): int {
            return StoWorkerPayment::query()
                ->where('worker_id', $worker->id)
                ->where('status', 'pending')
                ->update([
                    'status' => 'paid',
                    'paid_at' => now()->toDateString(),
                ]);
        });
    }

    public function payPayment(StoWorkerPayment $payment): void
    {
        $payment->update([
            'status' => 'paid',
            'paid_at' => now()->toDateString(),
        ]);
    }
}
