<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Sto;

use App\Http\Controllers\Controller;
use App\Models\Sto\StoClient;
use App\Models\Sto\StoOrder;
use App\Models\Sto\StoWorker;
use App\Services\Sto\StoOrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private readonly StoOrderService $orderService,
    ) {
    }

    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $orders = StoOrder::query()
            ->with(['client', 'workers.worker'])
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.sto.orders.index', [
            'orders' => $orders,
            'statuses' => StoOrder::STATUSES,
            'currentStatus' => $status,
        ]);
    }

    public function create(): View
    {
        return view('admin.sto.orders.create', [
            'clients' => StoClient::query()->orderBy('name')->get(),
            'workers' => StoWorker::query()->where('is_active', true)->orderBy('name')->get(),
            'statuses' => StoOrder::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
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

        $this->orderService->createOrder(
            $validated,
            $validated['workers'] ?? [],
        );

        return redirect()->route('admin.sto.orders.index')->with('success', 'Заказ создан.');
    }

    public function updateStatus(Request $request, StoOrder $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,in_progress,ready,completed,cancelled'],
        ]);

        $this->orderService->updateStatus($order, $validated['status']);

        return back()->with('success', 'Статус обновлён.');
    }

    public function destroy(StoOrder $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('admin.sto.orders.index')->with('success', 'Заказ удалён.');
    }
}
