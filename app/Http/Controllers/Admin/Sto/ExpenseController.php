<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Sto;

use App\Http\Controllers\Controller;
use App\Models\Sto\StoExpense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function index(): View
    {
        $expenses = StoExpense::query()->orderByDesc('expense_date')->get();

        return view('admin.sto.expenses.index', [
            'expenses' => $expenses,
            'categories' => StoExpense::CATEGORIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'expense_date' => ['required', 'date'],
            'category' => ['required', 'in:rent,utilities,taxes,advertising,tools,other'],
            'description' => ['required', 'string', 'max:1000'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        StoExpense::query()->create($validated);

        return back()->with('success', 'Расход добавлен.');
    }

    public function destroy(StoExpense $expense): RedirectResponse
    {
        $expense->delete();

        return back()->with('success', 'Расход удалён.');
    }
}
