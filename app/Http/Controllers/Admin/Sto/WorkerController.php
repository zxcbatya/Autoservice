<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Sto;

use App\Http\Controllers\Controller;
use App\Models\Sto\StoWorker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkerController extends Controller
{
    public function index(): View
    {
        $workers = StoWorker::query()->orderBy('name')->get();

        return view('admin.sto.workers.index', compact('workers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'payment_type' => ['required', 'in:percent,fixed'],
            'rate' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        StoWorker::query()->create($validated);

        return back()->with('success', 'Мастер добавлен.');
    }

    public function destroy(StoWorker $worker): RedirectResponse
    {
        $worker->delete();

        return back()->with('success', 'Мастер удалён.');
    }
}
