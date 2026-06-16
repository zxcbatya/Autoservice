<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Sto\Api;

use App\Http\Controllers\Controller;
use App\Models\Sto\StoOrder;
use App\Models\Sto\StoWorker;
use App\Models\Sto\StoWorkerPayment;
use App\Services\Sto\StoOrderService;
use App\Services\Sto\StoPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoApiController extends Controller
{
    public function __construct(
        private readonly StoOrderService $orderService,
        private readonly StoPaymentService $paymentService,
    ) {
    }

    public function orders(Request $request): JsonResponse
    {
        $status = $request->string('status')->toString();

        $orders = StoOrder::query()
            ->with(['client', 'workers.worker'])
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate((int) $request->input('per_page', 15));

        return response()->json($orders);
    }

    public function updateOrderStatus(Request $request, StoOrder $order): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,in_progress,ready,completed,cancelled'],
        ]);

        $order = $this->orderService->updateStatus($order, $validated['status']);

        return response()->json(['success' => true, 'order' => $order]);
    }

    public function storeOrder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:sto_clients,id'],
            'service' => ['required', 'string', 'max:500'],
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:new,in_progress,ready,completed,cancelled'],
            'workers' => ['nullable', 'array'],
            'workers.*.worker_id' => ['nullable', 'exists:sto_workers,id'],
            'workers.*.amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        $order = $this->orderService->createOrder(
            $validated,
            $validated['workers'] ?? [],
        );

        return response()->json(['success' => true, 'order' => $order], 201);
    }

    public function payWorker(StoWorker $worker): JsonResponse
    {
        $count = $this->paymentService->payWorker($worker);

        return response()->json(['success' => true, 'paid_count' => $count]);
    }

    public function payPayment(StoWorkerPayment $payment): JsonResponse
    {
        if ($payment->status === 'paid') {
            return response()->json(['success' => false, 'message' => 'Уже выплачено'], 422);
        }

        $this->paymentService->payPayment($payment);

        return response()->json(['success' => true, 'payment' => $payment->fresh()]);
    }
}
