<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Sto;

use App\Http\Controllers\Controller;
use App\Models\Sto\StoClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $clients = StoClient::query()->orderBy('name')->get();

        return view('admin.sto.clients.index', compact('clients'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        StoClient::query()->create($validated);

        return back()->with('success', 'Клиент добавлен.');
    }

    public function destroy(StoClient $client): RedirectResponse
    {
        $client->delete();

        return back()->with('success', 'Клиент удалён.');
    }
}
