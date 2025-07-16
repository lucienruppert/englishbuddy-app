<?php
$files = [
  'js/jquery-1.11.1.min.js',
  'js/jquery-ui.min.js',
  'js/jquery-ui.min.css'
];

echo "<h1>Static File Test</h1>";
foreach ($files as $file) {
  $path = __DIR__ . '/' . $file;
  echo "<h2>Testing: $file</h2>";
  echo "File exists: " . (file_exists($path) ? "Yes" : "No") . "<br>";
  if (file_exists($path)) {
    echo "File size: " . filesize($path) . " bytes<br>";
    echo "MIME type: " . mime_content_type($path) . "<br>";
    echo "Can read: " . (is_readable($path) ? "Yes" : "No") . "<br>";
  }
  echo "<hr>";
}
