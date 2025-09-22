<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TarifRental;
use App\Models\Motor;
use Illuminate\Http\Request;

class TarifController extends Controller
{
  public function index()
  {
    $tarifs = TarifRental::with(['motor.owner'])
      ->latest()
      ->paginate(10);

    // Statistics
    $stats = [
      'total_tarifs' => TarifRental::count(),
      'active_tarifs' => TarifRental::where('is_active', true)->count(),
      'avg_price' => TarifRental::where('is_active', true)->avg('tarif_harian'),
      'motors_without_tarif' => Motor::whereDoesntHave('tarifRental')->count(),
    ];

    return view('admin.tarif.index', compact('tarifs', 'stats'));
  }

  public function create()
  {
    // Get motors that don't have active tariffs
    $motors = Motor::whereDoesntHave('tarifRental', function ($query) {
      $query->where('is_active', true);
    })->with('owner')->get();

    return view('admin.tarif.create', compact('motors'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'motor_id' => 'required|exists:motors,id',
      'tarif_harian' => 'required|numeric|min:0',
      'tarif_mingguan' => 'nullable|numeric|min:0',
      'tarif_bulanan' => 'nullable|numeric|min:0',
      'is_active' => 'boolean'
    ]);

    // Deactivate existing tarifs for this motor if setting as active
    if ($request->is_active) {
      TarifRental::where('motor_id', $request->motor_id)
        ->update(['is_active' => false]);
    }

    TarifRental::create([
      'motor_id' => $request->motor_id,
      'tarif_harian' => $request->tarif_harian,
      'tarif_mingguan' => $request->tarif_mingguan,
      'tarif_bulanan' => $request->tarif_bulanan,
      'is_active' => $request->is_active ?? false,
    ]);

    return redirect()->route('admin.tarif.index')
      ->with('success', 'Tarif rental berhasil ditambahkan.');
  }

  public function show(TarifRental $tarif)
  {
    $tarif->load(['motor.owner', 'motor.penyewaans']);
    return view('admin.tarif.show', compact('tarif'));
  }

  public function edit(TarifRental $tarif)
  {
    $motors = Motor::with('owner')->get();
    return view('admin.tarif.edit', compact('tarif', 'motors'));
  }

  public function update(Request $request, TarifRental $tarif)
  {
    $request->validate([
      'motor_id' => 'required|exists:motors,id',
      'tarif_harian' => 'required|numeric|min:0',
      'tarif_mingguan' => 'nullable|numeric|min:0',
      'tarif_bulanan' => 'nullable|numeric|min:0',
      'is_active' => 'boolean'
    ]);

    // Deactivate existing tarifs for this motor if setting as active
    if ($request->is_active && $request->is_active != $tarif->is_active) {
      TarifRental::where('motor_id', $request->motor_id)
        ->where('id', '!=', $tarif->id)
        ->update(['is_active' => false]);
    }

    $tarif->update([
      'motor_id' => $request->motor_id,
      'tarif_harian' => $request->tarif_harian,
      'tarif_mingguan' => $request->tarif_mingguan,
      'tarif_bulanan' => $request->tarif_bulanan,
      'is_active' => $request->is_active ?? false,
    ]);

    return redirect()->route('admin.tarif.index')
      ->with('success', 'Tarif rental berhasil diperbarui.');
  }

  public function destroy(TarifRental $tarif)
  {
    $tarif->delete();

    return redirect()->route('admin.tarif.index')
      ->with('success', 'Tarif rental berhasil dihapus.');
  }

  public function setRates(Request $request, Motor $motor)
  {
    $request->validate([
      'tarif_harian' => 'required|numeric|min:0',
      'tarif_mingguan' => 'nullable|numeric|min:0',
      'tarif_bulanan' => 'nullable|numeric|min:0',
    ]);

    // Deactivate existing tarifs
    TarifRental::where('motor_id', $motor->id)
      ->update(['is_active' => false]);

    // Create new active tarif
    TarifRental::create([
      'motor_id' => $motor->id,
      'tarif_harian' => $request->tarif_harian,
      'tarif_mingguan' => $request->tarif_mingguan,
      'tarif_bulanan' => $request->tarif_bulanan,
      'is_active' => true,
    ]);

    return back()->with('success', 'Tarif rental berhasil diatur.');
  }
}
