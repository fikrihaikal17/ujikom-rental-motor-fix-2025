<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class RenterOnly
{
  /**
   * Handle an incoming request for renter-only access
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (!Auth::check()) {
      return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    /** @var User $user */
    $user = Auth::user();

    if (!$user->isRenter()) {
      logger()->warning('Unauthorized renter access attempt', [
        'user_id' => $user->id,
        'user_role' => $user->role->value,
        'ip' => request()->ip(),
      ]);

      $redirectRoute = $user->getDashboardRoute();
      return redirect()->route($redirectRoute)
        ->with('error', 'Akses ditolak. Halaman ini hanya untuk Penyewa.');
    }

    return $next($request);
  }
}
