<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
  /**
   * Handle an incoming request for admin-only access
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (!Auth::check()) {
      return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    /** @var User $user */
    $user = Auth::user();

    if (!$user->isAdmin()) {
      logger()->warning('Unauthorized admin access attempt', [
        'user_id' => $user->id,
        'user_role' => $user->role->value,
        'ip' => request()->ip(),
      ]);

      $redirectRoute = $user->getDashboardRoute();
      return redirect()->route($redirectRoute)
        ->with('error', 'Akses ditolak. Halaman ini hanya untuk Administrator.');
    }

    return $next($request);
  }
}
