<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next, string $role): Response
  {
    // Check if user is authenticated
    if (!Auth::check()) {
      return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    /** @var User $user */
    $user = Auth::user();
    $requiredRole = UserRole::from($role);

    // Check if user has the required role
    if (!$user->hasRole($requiredRole)) {
      return $this->handleUnauthorizedAccess($user, $requiredRole);
    }

    return $next($request);
  }

  /**
   * Handle unauthorized access attempt
   */
  protected function handleUnauthorizedAccess($user, UserRole $requiredRole): Response
  {
    // Log the unauthorized access attempt
    logger()->warning('Unauthorized access attempt', [
      'user_id' => $user->id,
      'user_role' => $user->role->value,
      'required_role' => $requiredRole->value,
      'ip' => request()->ip(),
      'user_agent' => request()->userAgent(),
    ]);

    // Redirect to user's appropriate dashboard with error message
    $redirectRoute = $user->getDashboardRoute();
    $errorMessage = $this->getUnauthorizedMessage($user->role, $requiredRole);

    return redirect()->route($redirectRoute)->with('error', $errorMessage);
  }

  /**
   * Get appropriate error message for unauthorized access
   */
  protected function getUnauthorizedMessage(UserRole $userRole, UserRole $requiredRole): string
  {
    return match ($requiredRole) {
      UserRole::ADMIN => 'Akses ditolak. Halaman ini hanya untuk Administrator.',
      UserRole::PEMILIK => 'Akses ditolak. Halaman ini hanya untuk Pemilik Kendaraan.',
      UserRole::PENYEWA => 'Akses ditolak. Halaman ini hanya untuk Penyewa.',
      default => 'Anda tidak memiliki akses ke halaman ini.',
    };
  }

  /**
   * Check if user can access multiple roles
   */
  public function handleMultipleRoles(Request $request, Closure $next, ...$roles): Response
  {
    if (!Auth::check()) {
      return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    /** @var User $user */
    $user = Auth::user();
    $allowedRoles = array_map(fn($role) => UserRole::from($role), $roles);

    foreach ($allowedRoles as $role) {
      if ($user->hasRole($role)) {
        return $next($request);
      }
    }

    return $this->handleUnauthorizedAccess($user, $allowedRoles[0]);
  }
}
