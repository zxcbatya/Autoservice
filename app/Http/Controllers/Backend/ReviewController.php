<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $reviews = Review::query()->orderByDesc('created_at')->paginate(20);
        return view('admin.review.index', compact('reviews'));
    }

    public function edit(Review $review): View
    {
        return view('admin.review.edit', compact('review'));
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'car' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
        ]);

        $review->update($validated);

        return redirect()->route('admin.review.index')->with('success', 'Отзыв успешно обновлен');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();
        return redirect()->route('admin.review.index')->with('success', 'Отзыв удален');
    }
} 