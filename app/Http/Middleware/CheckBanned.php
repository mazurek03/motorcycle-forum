<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Sprawdź czy użytkownik jest zalogowany
        if (Auth::check()) {
            $user = Auth::user();

            // 2. Jeśli ma datę bana i jest ona w PRZYSZŁOŚCI
            if ($user->banned_until && $user->banned_until->isFuture()) {
                $until = $user->banned_until->format('d.m.Y H:i');
                
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('error', "KONTO ZABLOKOWANE DO: $until");
            }

            // 3. Jeśli data bana minęła, czyścimy ją w bazie
            if ($user->banned_until && $user->banned_until->isPast()) {
                $user->update(['banned_until' => null]);
            }
        }

        return $next($request);
    }
}