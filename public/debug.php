<?php
// Debug info untuk sistem
echo "<h1>Debug Sistem</h1>";

echo "<h2>PHP Info:</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Max Upload Size: " . ini_get('upload_max_filesize') . "<br>";
echo "Max Post Size: " . ini_get('post_max_size') . "<br>";
echo "Max Execution Time: " . ini_get('max_execution_time') . "<br>";

echo "<h2>Directory Info:</h2>";
echo "Storage Path: " . storage_path() . "<br>";
echo "Public Storage Path: " . storage_path('app/public') . "<br>";
echo "Motors Directory: " . storage_path('app/public/motors') . "<br>";
echo "Motors Directory Exists: " . (is_dir(storage_path('app/public/motors')) ? 'YES' : 'NO') . "<br>";
echo "Motors Directory Writable: " . (is_writable(storage_path('app/public/motors')) ? 'YES' : 'NO') . "<br>";

echo "<h2>Storage Link:</h2>";
echo "Public Storage Link: " . public_path('storage') . "<br>";
echo "Storage Link Exists: " . (is_link(public_path('storage')) ? 'YES' : 'NO') . "<br>";

echo "<h2>Files in Motors Directory:</h2>";
$motorsPath = storage_path('app/public/motors');
if (is_dir($motorsPath)) {
  $files = scandir($motorsPath);
  foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
      echo $file . "<br>";
    }
  }
  if (count($files) <= 2) {
    echo "No files found<br>";
  }
} else {
  echo "Directory does not exist<br>";
}
