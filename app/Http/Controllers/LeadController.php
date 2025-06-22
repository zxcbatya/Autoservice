<?php

namespace App\Http\Controllers;

use App\Notifications\NewLeadNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class LeadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'car' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Notification::route('telegram', env('TELEGRAM_CHAT_ID'))
            ->notify(new NewLeadNotification($validated));

        return response()->json(['success' => true, 'message' => 'Ваша заявка успешно отправлена!']);
    }
} 