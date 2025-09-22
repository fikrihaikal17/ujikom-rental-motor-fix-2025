<!DOCTYPE html>
<html>

<head>
  <title>Debug Image Paths</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    .debug-item {
      margin: 20px 0;
      padding: 15px;
      border: 1px solid #ccc;
    }

    .debug-item img {
      max-width: 200px;
      height: auto;
    }

    .debug-path {
      background: #f5f5f5;
      padding: 10px;
      font-family: monospace;
    }
  </style>
</head>

<body>
  <h1>Debug Image Paths</h1>

  <?php
  require_once __DIR__ . '/../vendor/autoload.php';

  $app = require_once __DIR__ . '/../bootstrap/app.php';
  $app->boot();

  // Get latest motors
  $motors = \App\Models\Motor::latest()->take(3)->get();

  foreach ($motors as $motor) {
    echo "<div class='debug-item'>";
    echo "<h3>{$motor->nama_motor}</h3>";
    echo "<p><strong>Photo DB Value:</strong> {$motor->photo}</p>";
    echo "<p><strong>Asset URL:</strong> " . asset('storage/' . $motor->photo) . "</p>";
    echo "<p><strong>File Exists:</strong> " . (file_exists(public_path('storage/' . $motor->photo)) ? 'YES' : 'NO') . "</p>";
    echo "<div class='debug-path'>" . asset('storage/' . $motor->photo) . "</div>";
    if ($motor->photo) {
      echo "<img src='" . asset('storage/' . $motor->photo) . "' alt='{$motor->nama_motor}' />";
    }
    echo "</div>";
  }
  ?>
</body>

</html>