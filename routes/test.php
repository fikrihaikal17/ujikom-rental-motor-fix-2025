<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/test-upload', function (Request $request) {
  try {
    $request->validate([
      'foto_motor' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('foto_motor')) {
      $file = $request->file('foto_motor');
      $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
      $path = $file->storeAs('motors', $fileName, 'public');

      return response()->json([
        'success' => true,
        'message' => 'File uploaded successfully',
        'filename' => $fileName,
        'path' => $path,
        'url' => asset('storage/' . $path)
      ]);
    }

    return response()->json(['error' => 'No file uploaded']);
  } catch (\Exception $e) {
    return response()->json([
      'error' => true,
      'message' => $e->getMessage()
    ]);
  }
});
