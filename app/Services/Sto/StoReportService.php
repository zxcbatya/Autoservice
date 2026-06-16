<?php

declare(strict_types=1);

namespace App\Services\Sto;

use App\Models\Sto\StoExpense;
use App\Models\Sto\StoOrder;
use App\Models\Sto\StoWorkerPayment;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class StoReportService
{
    /**
     * @return array{revenue: float, expenses: float, salaries: float, profit: float, orders_count: int, orders: Collection}
     */
    public function buildReport(?string $dateFrom, ?string $dateTo): array
    {
        $from = $dateFrom ? Carbon::parse($dateFrom)->startOfDay() : now()->startOfMonth();
        $to = $dateTo ? Carbon::parse($dateTo)->endOfDay() : now()->endOfDay();

        $orders = StoOrder::query()
            ->with('client')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$from, $to])
            ->orderByDesc('created_at')
            ->get();

        $revenue = (float) $orders->sum('amount');

        $expenses = (float) StoExpense::query()
            ->whereBetween('expense_date', [$from->toDateString(), $to->toDateString()])
            ->sum('amount');

        $salaries = (float) StoWorkerPayment::query()
            ->where('status', 'paid')
            ->whereBetween('paid_at', [$from->toDateString(), $to->toDateString()])
            ->sum('amount');

        $ordersCount = StoOrder::query()
            ->whereBetween('created_at', [$from, $to])
            ->where('status', '!=', 'cancelled')
            ->count();

        return [
            'revenue' => $revenue,
            'expenses' => $expenses,
            'salaries' => $salaries,
            'profit' => $revenue - $expenses - $salaries,
            'orders_count' => $ordersCount,
            'orders' => $orders,
            'date_from' => $from->toDateString(),
            'date_to' => $to->toDateString(),
        ];
    }
}
