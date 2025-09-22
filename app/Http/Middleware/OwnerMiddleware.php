<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Check if user has 'pemilik' role
        if ($user->role->value !== 'pemilik') {
            // Redirect based on their actual role
            $redirectRoute = match ($user->role->value) {
                'admin' => 'admin.dashboard',
                'penyewa' => 'home', // or whatever the renter dashboard will be
                default => 'home'
            };

            return redirect()->route($redirectRoute)
                ->with('error', 'Anda tidak memiliki akses ke halaman pemilik motor.');
        }

        return $next($request);
    }
}
