<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureStoAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user === null) {
            return redirect()->guest(route('login'));
        }

        if (! $user->is_admin && ! $user->hasAnyRole(['admin', 'manager'])) {
            abort(403, 'Доступ запрещён.');
        }

        return $next($request);
    }
}
