<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Enums\UserRole;

class RegisterController extends Controller
{
  /**
   * Show the registration form (only for owner and renter roles)
   */
  public function showRegistrationForm(): View
  {
    return view('auth.register');
  }

  /**
   * Handle registration for owner (pemilik) and renter (penyewa) roles
   */
  public function register(Request $request): RedirectResponse
  {
    // Validate the registration data
    $request->validate([
      'nama' => ['required', 'string', 'max:100'],
      'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
      'no_tlpn' => ['required', 'string', 'max:15'],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
      'role' => ['required', 'in:pemilik,penyewa'],
    ], [
      'nama.required' => 'Nama harus diisi.',
      'nama.max' => 'Nama maksimal 100 karakter.',
      'email.required' => 'Email harus diisi.',
      'email.email' => 'Format email tidak valid.',
      'email.unique' => 'Email sudah terdaftar.',
      'no_tlpn.required' => 'Nomor telepon harus diisi.',
      'no_tlpn.max' => 'Nomor telepon maksimal 15 karakter.',
      'password.required' => 'Password harus diisi.',
      'password.confirmed' => 'Konfirmasi password tidak cocok.',
      'role.required' => 'Role harus dipilih.',
      'role.in' => 'Role yang dipilih tidak valid.',
    ]);

    // Create the user
    $user = User::create([
      'nama' => $request->nama,
      'email' => $request->email,
      'no_tlpn' => $request->no_tlpn,
      'password' => Hash::make($request->password),
      'role' => UserRole::from($request->role),
    ]);

    // Auto-login the user after registration
    Auth::login($user);

    // Redirect based on role
    return $this->redirectBasedOnRole($user);
  }

  /**
   * Redirect user based on their role after registration
   */
  protected function redirectBasedOnRole($user): RedirectResponse
  {
    $welcomeMessage = match ($user->role) {
      UserRole::PEMILIK => 'Selamat datang! Silakan daftarkan motor Anda untuk mulai mendapatkan penghasilan.',
      UserRole::PENYEWA => 'Selamat datang! Mulai cari motor yang ingin Anda sewa.',
      default => 'Selamat datang di RideNow!',
    };

    return match ($user->role) {
      UserRole::PEMILIK => redirect()->route('owner.dashboard')->with('success', $welcomeMessage),
      UserRole::PENYEWA => redirect()->route('renter.dashboard')->with('success', $welcomeMessage),
      default => redirect()->route('login')->with('error', 'Role tidak valid.'),
    };
  }

  /**
   * Validate registration data
   */
  protected function validateRegistration(Request $request): array
  {
    return $request->validate([
      'nama' => ['required', 'string', 'max:100'],
      'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
      'no_tlpn' => ['required', 'string', 'max:15', 'regex:/^08[0-9]{8,13}$/'],
      'password' => ['required', 'confirmed', Rules\Password::min(6)],
      'role' => ['required', 'in:pemilik,penyewa'],
    ], [
      'nama.required' => 'Nama lengkap harus diisi.',
      'nama.max' => 'Nama maksimal 100 karakter.',
      'email.required' => 'Alamat email harus diisi.',
      'email.email' => 'Format email tidak valid.',
      'email.unique' => 'Email sudah terdaftar sebelumnya.',
      'no_tlpn.required' => 'Nomor telepon harus diisi.',
      'no_tlpn.regex' => 'Format nomor telepon tidak valid. Gunakan format 08xxxxxxxxxx.',
      'password.required' => 'Password harus diisi.',
      'password.min' => 'Password minimal 6 karakter.',
      'password.confirmed' => 'Konfirmasi password tidak cocok.',
      'role.required' => 'Silakan pilih sebagai Pemilik atau Penyewa.',
      'role.in' => 'Role yang dipilih tidak valid.',
    ]);
  }

  /**
   * Create a new user instance after validation
   */
  protected function create(array $data): User
  {
    return User::create([
      'nama' => $data['nama'],
      'email' => $data['email'],
      'no_tlpn' => $data['no_tlpn'],
      'password' => Hash::make($data['password']),
      'role' => UserRole::from($data['role']),
    ]);
  }

  /**
   * Get available roles for registration (excludes admin)
   */
  public function getAvailableRoles(): array
  {
    return UserRole::getRegistrationRoles();
  }

  /**
   * Check if phone number is unique
   */
  protected function phoneNumberExists(string $phoneNumber): bool
  {
    return User::where('no_tlpn', $phoneNumber)->exists();
  }

  /**
   * Normalize phone number format
   */
  protected function normalizePhoneNumber(string $phoneNumber): string
  {
    // Remove any non-digit characters
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    // Ensure it starts with 08
    if (!str_starts_with($phoneNumber, '08')) {
      if (str_starts_with($phoneNumber, '8')) {
        $phoneNumber = '0' . $phoneNumber;
      } elseif (str_starts_with($phoneNumber, '62')) {
        $phoneNumber = '0' . substr($phoneNumber, 2);
      }
    }

    return $phoneNumber;
  }

  /**
   * Check if email domain is allowed
   */
  protected function isEmailDomainAllowed(string $email): bool
  {
    $allowedDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com'];
    $domain = substr(strrchr($email, "@"), 1);

    return in_array($domain, $allowedDomains) ||
      filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
  }

  /**
   * Generate welcome message based on role
   */
  protected function getWelcomeMessage(UserRole $role): string
  {
    return match ($role) {
      UserRole::PEMILIK => 'Selamat bergabung sebagai Pemilik Kendaraan! Daftarkan motor Anda untuk mulai mendapatkan penghasilan tambahan.',
      UserRole::PENYEWA => 'Selamat bergabung sebagai Penyewa! Temukan motor terbaik untuk kebutuhan perjalanan Anda.',
      default => 'Selamat bergabung di RideNow!',
    };
  }

  /**
   * Send welcome email to new user
   */
  protected function sendWelcomeEmail(User $user): void
  {
    // Implementation for sending welcome email
    // This can be implemented later with Laravel's mail system
  }
}
