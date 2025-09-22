<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Enums\UserRole;

class LoginController extends Controller
{
  /**
   * Show the login form (single form for all roles)
   */
  public function showLoginForm(): View
  {
    return view('auth.login');
  }

  /**
   * Handle login attempt with automatic role-based redirection
   */
  public function login(Request $request): RedirectResponse
  {
    $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
    ]);

    $credentials = $request->only('email', 'password');

    // Attempt to authenticate the user
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
      $request->session()->regenerate();

      // Get the authenticated user
      $user = Auth::user();

      // Redirect based on user role
      return $this->redirectBasedOnRole($user);
    }

    // Authentication failed
    throw ValidationException::withMessages([
      'email' => ['Kredensial yang diberikan tidak cocok dengan data kami.'],
    ]);
  }

  /**
   * Redirect user based on their role
   */
  protected function redirectBasedOnRole($user): RedirectResponse
  {
    return match ($user->role) {
      UserRole::ADMIN => redirect()->route('admin.dashboard'),
      UserRole::PEMILIK => redirect()->route('owner.dashboard'),
      UserRole::PENYEWA => redirect()->route('renter.dashboard'),
      default => redirect()->route('login')->with('error', 'Role tidak valid.'),
    };
  }

  /**
   * Logout the user
   */
  public function logout(Request $request): RedirectResponse
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
  }

  /**
   * Handle post-authentication redirection (Laravel's authenticated method)
   */
  protected function authenticated(Request $request, $user): RedirectResponse
  {
    return $this->redirectBasedOnRole($user);
  }

  /**
   * Get the guard to be used during authentication
   */
  protected function guard()
  {
    return Auth::guard();
  }

  /**
   * Validate login credentials
   */
  protected function validateLogin(Request $request): void
  {
    $request->validate([
      'email' => ['required', 'string', 'email'],
      'password' => ['required', 'string'],
    ], [
      'email.required' => 'Email harus diisi.',
      'email.email' => 'Format email tidak valid.',
      'password.required' => 'Password harus diisi.',
    ]);
  }

  /**
   * Get the login credentials from the request
   */
  protected function credentials(Request $request): array
  {
    return $request->only('email', 'password');
  }

  /**
   * Handle too many login attempts
   */
  protected function sendLockoutResponse(Request $request)
  {
    $seconds = $this->limiter()->availableIn(
      $this->throttleKey($request)
    );

    throw ValidationException::withMessages([
      'email' => [trans('auth.throttle', [
        'seconds' => $seconds,
        'minutes' => ceil($seconds / 60),
      ])],
    ])->status(429);
  }

  /**
   * Get the throttle key for the given request
   */
  protected function throttleKey(Request $request): string
  {
    return strtolower($request->input('email')) . '|' . $request->ip();
  }

  /**
   * Get the rate limiter instance
   */
  protected function limiter()
  {
    return app('limiter');
  }

  /**
   * Check if the user has exceeded login attempts
   */
  protected function hasTooManyLoginAttempts(Request $request): bool
  {
    return $this->limiter()->tooManyAttempts(
      $this->throttleKey($request),
      5 // 5 attempts
    );
  }

  /**
   * Increment the login attempts for the user
   */
  protected function incrementLoginAttempts(Request $request): void
  {
    $this->limiter()->hit(
      $this->throttleKey($request),
      60 * 5 // 5 minutes lockout
    );
  }

  /**
   * Clear the login locks for the given user credentials
   */
  protected function clearLoginAttempts(Request $request): void
  {
    $this->limiter()->clear($this->throttleKey($request));
  }
}
