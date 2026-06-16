<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Authenticate extends Middleware
{
    /**
     * @throws ValidationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect()->guest(route('login'));
        }

        if (! $user->is_admin && ! $user->hasAnyRole(['admin', 'manager'])) {
            Auth::logout();

            return redirect()->guest(route('login'));
        }

        return $next($request);
    }
}
