# Symfony\Component\Routing\Exception\RouteNotFoundException - Internal Server Error
Route [admin.penyewaan.export] not defined.

PHP 8.4.12
Laravel 12.30.1
127.0.0.1:8000

## Stack Trace

0 - vendor\laravel\framework\src\Illuminate\Routing\UrlGenerator.php:526
1 - vendor\laravel\framework\src\Illuminate\Foundation\helpers.php:871
2 - resources\views\admin\penyewaan\index.blade.php:14
3 - vendor\laravel\framework\src\Illuminate\Filesystem\Filesystem.php:123
4 - vendor\laravel\framework\src\Illuminate\Filesystem\Filesystem.php:124
5 - vendor\laravel\framework\src\Illuminate\View\Engines\PhpEngine.php:57
6 - vendor\laravel\framework\src\Illuminate\View\Engines\CompilerEngine.php:76
7 - vendor\laravel\framework\src\Illuminate\View\View.php:208
8 - vendor\laravel\framework\src\Illuminate\View\View.php:191
9 - vendor\laravel\framework\src\Illuminate\View\View.php:160
10 - vendor\laravel\framework\src\Illuminate\Http\Response.php:78
11 - vendor\laravel\framework\src\Illuminate\Http\Response.php:34
12 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:939
13 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:906
14 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:821
15 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:180
16 - app\Http\Middleware\AdminOnly.php:38
17 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
18 - vendor\laravel\framework\src\Illuminate\Routing\Middleware\SubstituteBindings.php:50
19 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
20 - vendor\laravel\framework\src\Illuminate\Auth\Middleware\Authenticate.php:63
21 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
22 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken.php:87
23 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
24 - vendor\laravel\framework\src\Illuminate\View\Middleware\ShareErrorsFromSession.php:48
25 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
26 - vendor\laravel\framework\src\Illuminate\Session\Middleware\StartSession.php:120
27 - vendor\laravel\framework\src\Illuminate\Session\Middleware\StartSession.php:63
28 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
29 - vendor\laravel\framework\src\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse.php:36
30 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
31 - vendor\laravel\framework\src\Illuminate\Cookie\Middleware\EncryptCookies.php:74
32 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
33 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:137
34 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:821
35 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:800
36 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:764
37 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:753
38 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Kernel.php:200
39 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:180
40 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\TransformsRequest.php:21
41 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull.php:31
42 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
43 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\TransformsRequest.php:21
44 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\TrimStrings.php:51
45 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
46 - vendor\laravel\framework\src\Illuminate\Http\Middleware\ValidatePostSize.php:27
47 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
48 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance.php:109
49 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
50 - vendor\laravel\framework\src\Illuminate\Http\Middleware\HandleCors.php:48
51 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
52 - vendor\laravel\framework\src\Illuminate\Http\Middleware\TrustProxies.php:58
53 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
54 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks.php:22
55 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
56 - vendor\laravel\framework\src\Illuminate\Http\Middleware\ValidatePathEncoding.php:26
57 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
58 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:137
59 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Kernel.php:175
60 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Kernel.php:144
61 - vendor\laravel\framework\src\Illuminate\Foundation\Application.php:1220
62 - public\index.php:20
63 - vendor\laravel\framework\src\Illuminate\Foundation\resources\server.php:23

## Request

GET /admin/penyewaan

## Headers

* **host**: 127.0.0.1:8000
* **connection**: keep-alive
* **cache-control**: max-age=0
* **sec-ch-ua**: "Chromium";v="140", "Not=A?Brand";v="24", "Brave";v="140"
* **sec-ch-ua-mobile**: ?0
* **sec-ch-ua-platform**: "Windows"
* **upgrade-insecure-requests**: 1
* **user-agent**: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36
* **accept**: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8
* **sec-gpc**: 1
* **accept-language**: en-US,en;q=0.9
* **sec-fetch-site**: same-origin
* **sec-fetch-mode**: navigate
* **sec-fetch-user**: ?1
* **sec-fetch-dest**: document
* **referer**: http://127.0.0.1:8000/admin/motors
* **accept-encoding**: gzip, deflate, br, zstd
* **cookie**: XSRF-TOKEN=eyJpdiI6IjRncmhCcnkrS1ZMYXNvU055bkdrSVE9PSIsInZhbHVlIjoiWWE1YmFkaGQwRnhqeng2RDdKYVNaTlNaQWRQSFlieGs5UmRPZjdKTkhvdU4xTEJ1NzlDTGcxU0xOcmw4Nm00MVV5RHorbVRZUkRWQUpqYTZhS0ZlclRxMUwvdzVzRzdLOXpWTGZYbitLODhjUk1pcFRsNERnZEIzQ2Q1SVZPeDQiLCJtYWMiOiIyM2YxOGM5OWIyNDk1OWFjNWE2YzQyOTUxNzc3YWRmMmQzM2ZhMWJkNGE1ZjIzNGI5ZmU4YTdkODFjODZkOWI0IiwidGFnIjoiIn0%3D; ridenow-session=eyJpdiI6Im11N2xXYWpoL2owMnErQXN6Uk5tZXc9PSIsInZhbHVlIjoidjIyeHZuTFBvbExUdndRQnFLV2s5aEdjNE1lZWM1YzZiWXRiZFNldHhveXhsTHE3OHNXTkIzYlIyOEFtVTNFRklZd0NzYjgvZWg3Q2JsYXp6Snd2ZXJ6T0xBUnc4bFJEOEFvZzFKYy9TRWtORjFoSHZLQloxWU0wV3ZyS1NCeUkiLCJtYWMiOiI4MzUxMDI4YmM5NTYxN2VlYzAyZjllMmQzNjU1NTdjZmRhYmY4Zjk2NDRhMTkzNTA0NTFmN2FhOTA3YmIyYTZhIiwidGFnIjoiIn0%3D

## Route Context

controller: App\Http\Controllers\Admin\PenyewaanController@index
route name: admin.penyewaan.index
middleware: web, auth, admin

## Route Parameters

No route parameter data available.

## Database Queries

* mysql - select * from `sessions` where `id` = 'dJlvpEe5Ctylhp4bokbTlxWMhZSwf6xulPkvntqb' limit 1 (4.26 ms)
* mysql - select * from `users` where `id` = 1 limit 1 (0.52 ms)
* mysql - select count(*) as aggregate from `penyewaans` (1.45 ms)
* mysql - select * from `penyewaans` order by `created_at` desc limit 10 offset 0 (0.37 ms)
* mysql - select * from `motors` where `motors`.`id` in (5) (0.45 ms)
* mysql - select * from `users` where `users`.`id` in (3) (0.24 ms)
* mysql - select * from `transaksis` where `transaksis`.`penyewaan_id` in (1) (0.81 ms)
* mysql - select count(*) as aggregate from `penyewaans` (0.94 ms)
* mysql - select count(*) as aggregate from `penyewaans` where `status` = 'pending' (0.42 ms)
* mysql - select count(*) as aggregate from `penyewaans` where `status` = 'active' (0.27 ms)
* mysql - select count(*) as aggregate from `penyewaans` where `status` = 'completed' (0.21 ms)
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penyewaan;
use App\Models\Motor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyewaanController extends Controller
{
  public function index(Request $request)
  {
    $query = Penyewaan::with(['motor', 'penyewa', 'transaksi']);

    // Filter by status
    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    // Filter by date range
    if ($request->filled('start_date')) {
      $query->whereDate('tanggal_mulai', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
      $query->whereDate('tanggal_selesai', '<=', $request->end_date);
    }

    // Search by motor or user name
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->whereHas('motor', function ($sq) use ($search) {
          $sq->where('nama_motor', 'like', "%{$search}%")
            ->orWhere('no_plat', 'like', "%{$search}%");
        })
          ->orWhereHas('penyewa', function ($sq) use ($search) {
            $sq->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
          });
      });
    }

    $penyewaans = $query->orderBy('created_at', 'desc')->paginate(10);

    // Statistics
    $totalPenyewaan = Penyewaan::count();
    $pendingPenyewaan = Penyewaan::where('status', 'pending')->count();
    $activePenyewaan = Penyewaan::where('status', 'active')->count();
    $completedPenyewaan = Penyewaan::where('status', 'completed')->count();

    return view('admin.penyewaan.index', compact(
      'penyewaans',
      'totalPenyewaan',
      'pendingPenyewaan',
      'activePenyewaan',
      'completedPenyewaan'
    ));
  }

  public function create()
  {
    $motors = Motor::where('status', 'verified')->get();
    $users = User::where('role', 'penyewa')->get();

    return view('admin.penyewaan.create', compact('motors', 'users'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'user_id' => 'required|exists:users,id',
      'motor_id' => 'required|exists:motors,id',
      'tanggal_mulai' => 'required|date|after_or_equal:today',
      'tanggal_selesai' => 'required|date|after:tanggal_mulai',
      'durasi_sewa' => 'required|integer|min:1',
      'total_harga' => 'required|numeric|min:0',
    ]);

    $penyewaan = Penyewaan::create($request->all());

    return redirect()->route('admin.penyewaan.index')
      ->with('success', 'Penyewaan berhasil dibuat');
  }

  public function show(Penyewaan $penyewaan)
  {
    $penyewaan->load(['motor', 'user', 'transaksi', 'payments']);

    return view('admin.penyewaan.show', compact('penyewaan'));
  }

  public function edit(Penyewaan $penyewaan)
  {
    $motors = Motor::where('status', 'verified')->get();
    $users = User::where('role', 'penyewa')->get();

    return view('admin.penyewaan.edit', compact('penyewaan', 'motors', 'users'));
  }

  public function update(Request $request, Penyewaan $penyewaan)
  {
    $request->validate([
      'user_id' => 'required|exists:users,id',
      'motor_id' => 'required|exists:motors,id',
      'tanggal_mulai' => 'required|date',
      'tanggal_selesai' => 'required|date|after:tanggal_mulai',
      'durasi_sewa' => 'required|integer|min:1',
      'total_harga' => 'required|numeric|min:0',
    ]);

    $penyewaan->update($request->all());

    return redirect()->route('admin.penyewaan.index')
      ->with('success', 'Penyewaan berhasil diupdate');
  }

  public function destroy(Penyewaan $penyewaan)
  {
    if ($penyewaan->status === 'active') {
      return back()->with('error', 'Tidak dapat menghapus penyewaan yang sedang aktif');
    }

    $penyewaan->delete();

    return redirect()->route('admin.penyewaan.index')
      ->with('success', 'Penyewaan berhasil dihapus');
  }

  public function updateStatus(Request $request, Penyewaan $penyewaan)
  {
    $request->validate([
      'status' => 'required|in:pending,confirmed,active,completed,cancelled'
    ]);

    $penyewaan->update(['status' => $request->status]);

    return back()->with('success', 'Status penyewaan berhasil diupdate');
  }

  public function exportCsv()
  {
    $penyewaans = Penyewaan::with(['motor', 'user'])->get();

    $filename = 'penyewaan_' . date('Y-m-d') . '.csv';

    $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function () use ($penyewaans) {
      $file = fopen('php://output', 'w');

      // Header
      fputcsv($file, [
        'ID',
        'Penyewa',
        'Motor',
        'Tanggal Mulai',
        'Tanggal Selesai',
        'Durasi (Hari)',
        'Total Harga',
        'Status',
        'Dibuat'
      ]);

      // Data
      foreach ($penyewaans as $penyewaan) {
        fputcsv($file, [
          $penyewaan->id,
          $penyewaan->penyewa->name,
          $penyewaan->motor->nama_motor,
          $penyewaan->tanggal_mulai,
          $penyewaan->tanggal_selesai,
          $penyewaan->durasi_sewa,
          $penyewaan->total_harga,
          $penyewaan->status,
          $penyewaan->created_at->format('Y-m-d H:i:s')
        ]);
      }

      fclose($file);
    };

    return response()->stream($callback, 200, $headers);
  }
}
