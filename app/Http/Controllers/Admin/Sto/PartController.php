<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Sto;

use App\Http\Controllers\Controller;
use App\Models\Sto\StoPart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartController extends Controller
{
    public function index(): View
    {
        $parts = StoPart::query()->orderBy('name')->get();

        return view('admin.sto.parts.index', compact('parts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'article' => ['nullable', 'string', 'max:100'],
            'quantity' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'min_quantity' => ['required', 'integer', 'min:0'],
        ]);

        StoPart::query()->create($validated);

        return back()->with('success', 'Запчасть добавлена.');
    }

    public function destroy(StoPart $part): RedirectResponse
    {
        $part->delete();

        return back()->with('success', 'Запчасть удалена.');
    }
}
