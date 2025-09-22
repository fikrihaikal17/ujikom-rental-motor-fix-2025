<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  public function index()
  {
    $users = User::latest()->paginate(10);
    return view('admin.users.index', compact('users'));
  }

  public function create()
  {
    return view('admin.users.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed',
      'role' => 'required|in:admin,owner,renter',
      'no_telp' => 'required|string|max:15',
      'alamat' => 'required|string',
    ]);

    User::create([
      'nama' => $request->nama,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => $request->role,
      'no_telp' => $request->no_telp,
      'alamat' => $request->alamat,
    ]);

    return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
  }

  public function show(User $user)
  {
    return view('admin.users.show', compact('user'));
  }

  public function edit(User $user)
  {
    return view('admin.users.edit', compact('user'));
  }

  public function update(Request $request, User $user)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
      'role' => 'required|in:admin,owner,renter',
      'no_telp' => 'required|string|max:15',
      'alamat' => 'required|string',
    ]);

    $updateData = [
      'nama' => $request->nama,
      'email' => $request->email,
      'role' => $request->role,
      'no_telp' => $request->no_telp,
      'alamat' => $request->alamat,
    ];

    if ($request->filled('password')) {
      $request->validate([
        'password' => 'string|min:8|confirmed',
      ]);
      $updateData['password'] = Hash::make($request->password);
    }

    $user->update($updateData);

    return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
  }

  public function destroy(User $user)
  {
    if ($user->id === Auth::id()) {
      return redirect()->route('admin.users.index')->with('error', 'Tidak dapat menghapus akun sendiri.');
    }

    $user->delete();
    return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
  }

  public function export()
  {
    $filename = 'users_export_' . now()->format('Y-m-d_H-i-s') . '.csv';

    $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function () {
      $file = fopen('php://output', 'w');

      // Header CSV
      fputcsv($file, ['ID', 'Nama', 'Email', 'Role', 'No. Telepon', 'Alamat', 'Tanggal Daftar', 'Status Verifikasi']);

      // Data
      $users = User::all();
      foreach ($users as $user) {
        fputcsv($file, [
          $user->id,
          $user->nama,
          $user->email,
          ucfirst($user->role),
          $user->no_telp,
          $user->alamat,
          $user->created_at->format('Y-m-d H:i:s'),
          $user->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi'
        ]);
      }

      fclose($file);
    };

    return response()->stream($callback, 200, $headers);
  }
}
