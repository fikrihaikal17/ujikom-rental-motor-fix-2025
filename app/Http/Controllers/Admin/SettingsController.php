<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
  public function index()
  {
    $admin = Auth::user();
    return view('admin.settings.index', compact('admin'));
  }

  public function updateProfile(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
      'phone' => 'nullable|string|max:20',
      'address' => 'nullable|string|max:500',
    ]);

    User::where('id', Auth::id())->update([
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'address' => $request->address,
    ]);

    return back()->with('success', 'Profil berhasil diperbarui.');
  }

  public function updatePassword(Request $request)
  {
    $request->validate([
      'current_password' => 'required',
      'password' => ['required', 'confirmed', Password::defaults()],
    ]);

    $admin = Auth::user();

    if (!Hash::check($request->current_password, $admin->password)) {
      return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
    }

    User::where('id', Auth::id())->update([
      'password' => Hash::make($request->password),
    ]);

    return back()->with('success', 'Password berhasil diperbarui.');
  }

  public function systemSettings()
  {
    // In a real application, you would store these in a settings table or config
    $settings = [
      'site_name' => config('app.name', 'RideNow'),
      'site_description' => 'Platform Rental Motor Terpercaya',
      'admin_email' => 'admin@ridenow.com',
      'max_rental_days' => 30,
      'default_late_fee' => 10000,
      'auto_approve_owners' => false,
      'require_verification' => true,
      'maintenance_mode' => false,
    ];

    return view('admin.settings.system', compact('settings'));
  }

  public function updateSystemSettings(Request $request)
  {
    $request->validate([
      'site_name' => 'required|string|max:255',
      'site_description' => 'required|string|max:500',
      'admin_email' => 'required|email',
      'max_rental_days' => 'required|integer|min:1|max:365',
      'default_late_fee' => 'required|numeric|min:0',
      'auto_approve_owners' => 'boolean',
      'require_verification' => 'boolean',
      'maintenance_mode' => 'boolean',
    ]);

    // In a real application, you would save these to a settings table or update config files
    // For demonstration, we'll just return success

    return back()->with('success', 'Pengaturan sistem berhasil diperbarui.');
  }

  public function notifications()
  {
    // Get notification settings for the admin
    $notificationSettings = [
      'email_new_registration' => true,
      'email_new_motor' => true,
      'email_new_rental' => true,
      'email_payment_received' => true,
      'email_rental_completed' => false,
      'email_maintenance_alerts' => true,
      'sms_urgent_notifications' => false,
      'browser_notifications' => true,
    ];

    return view('admin.settings.notifications', compact('notificationSettings'));
  }

  public function updateNotifications(Request $request)
  {
    $request->validate([
      'email_new_registration' => 'boolean',
      'email_new_motor' => 'boolean',
      'email_new_rental' => 'boolean',
      'email_payment_received' => 'boolean',
      'email_rental_completed' => 'boolean',
      'email_maintenance_alerts' => 'boolean',
      'sms_urgent_notifications' => 'boolean',
      'browser_notifications' => 'boolean',
    ]);

    // In a real application, you would save these notification preferences

    return back()->with('success', 'Pengaturan notifikasi berhasil diperbarui.');
  }

  public function backup()
  {
    // In a real application, you would implement database backup functionality
    $backups = [
      [
        'filename' => 'backup_2024_01_15_10_30_00.sql',
        'size' => '2.5 MB',
        'created_at' => '2024-01-15 10:30:00',
        'type' => 'manual'
      ],
      [
        'filename' => 'backup_2024_01_14_03_00_00.sql',
        'size' => '2.3 MB',
        'created_at' => '2024-01-14 03:00:00',
        'type' => 'automatic'
      ],
      [
        'filename' => 'backup_2024_01_13_03_00_00.sql',
        'size' => '2.2 MB',
        'created_at' => '2024-01-13 03:00:00',
        'type' => 'automatic'
      ],
    ];

    return view('admin.settings.backup', compact('backups'));
  }

  public function createBackup()
  {
    // In a real application, you would create a database backup
    // This is just a simulation

    return back()->with('success', 'Backup berhasil dibuat.');
  }

  public function logs()
  {
    // In a real application, you would read actual log files
    $logs = [
      [
        'level' => 'info',
        'message' => 'User login: admin@ridenow.com',
        'timestamp' => '2024-01-15 14:30:25',
        'context' => 'auth'
      ],
      [
        'level' => 'warning',
        'message' => 'Failed login attempt for: unknown@example.com',
        'timestamp' => '2024-01-15 14:25:12',
        'context' => 'auth'
      ],
      [
        'level' => 'info',
        'message' => 'New motor registered: Honda Beat 2023',
        'timestamp' => '2024-01-15 13:45:30',
        'context' => 'motor'
      ],
      [
        'level' => 'error',
        'message' => 'Payment gateway timeout for transaction TXN123456',
        'timestamp' => '2024-01-15 12:15:45',
        'context' => 'payment'
      ],
    ];

    return view('admin.settings.logs', compact('logs'));
  }
}
