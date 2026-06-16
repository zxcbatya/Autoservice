<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Sto;

use App\Http\Controllers\Controller;
use App\Models\Sto\StoWorker;
use App\Models\Sto\StoWorkerPayment;
use App\Services\Sto\StoPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(
        private readonly StoPaymentService $paymentService,
    ) {
    }

    public function index(): View
    {
        $workers = StoWorker::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(fn (StoWorker $worker) => [
                'model' => $worker,
                'debt' => $worker->pendingDebt(),
            ]);

        $pending = StoWorkerPayment::query()
            ->with(['worker', 'order'])
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        $history = StoWorkerPayment::query()
            ->with(['worker', 'order'])
            ->where('status', 'paid')
            ->orderByDesc('paid_at')
            ->limit(50)
            ->get();

        return view('admin.sto.payments.index', compact('workers', 'pending', 'history'));
    }

    public function payAll(StoWorker $worker): RedirectResponse
    {
        $count = $this->paymentService->payWorker($worker);

        if ($count === 0) {
            return back()->with('error', 'Нет выплат к оплате.');
        }

        return back()->with('success', "Выплачено записей: {$count}.");
    }

    public function payOne(StoWorkerPayment $payment): RedirectResponse
    {
        if ($payment->status === 'paid') {
            return back()->with('error', 'Выплата уже проведена.');
        }

        $this->paymentService->payPayment($payment);

        return back()->with('success', 'Выплата проведена.');
    }
}
