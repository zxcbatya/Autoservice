<?php

declare(strict_types=1);

namespace App\Services\Sto;

use App\Models\Sto\StoOrder;
use App\Models\Sto\StoOrderWorker;
use App\Models\Sto\StoWorkerPayment;
use Illuminate\Support\Facades\DB;

class StoOrderService
{
    public function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $prefix = "ORD-{$date}-";

        $last = StoOrder::query()
            ->where('number', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('number');

        $sequence = 1;
        if ($last !== null && preg_match('/-(\d{4})$/', $last, $matches)) {
            $sequence = (int) $matches[1] + 1;
        }

        return $prefix . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * @param  array<int, array{worker_id: int, amount: float|int|string}>  $workers
     */
    public function createOrder(array $data, array $workers): StoOrder
    {
        return DB::transaction(function () use ($data, $workers): StoOrder {
            $order = StoOrder::query()->create([
                'number' => $this->generateOrderNumber(),
                'client_id' => $data['client_id'],
                'service' => $data['service'],
                'amount' => $data['amount'],
                'status' => $data['status'] ?? 'new',
            ]);

            foreach ($workers as $workerRow) {
                if (empty($workerRow['worker_id'])) {
                    continue;
                }

                StoOrderWorker::query()->create([
                    'order_id' => $order->id,
                    'worker_id' => $workerRow['worker_id'],
                    'amount' => $workerRow['amount'] ?? 0,
                ]);

                StoWorkerPayment::query()->create([
                    'worker_id' => $workerRow['worker_id'],
                    'order_id' => $order->id,
                    'amount' => $workerRow['amount'] ?? 0,
                    'status' => 'pending',
                ]);
            }

            return $order->load(['client', 'workers.worker']);
        });
    }

    public function updateStatus(StoOrder $order, string $status): StoOrder
    {
        $order->update(['status' => $status]);

        return $order->fresh(['client', 'workers.worker']);
    }
}
