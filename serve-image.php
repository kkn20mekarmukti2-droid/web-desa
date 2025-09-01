<?php
// Simple image serving script
$file = $_GET['file'] ?? '';

if (empty($file)) {
    http_response_code(400);
    die('No file specified');
}

// Security: only allow images from specific directories
$allowedDirs = ['images/', 'img/', 'galeri/'];
$allowed = false;
foreach ($allowedDirs as $dir) {
    if (strpos($file, $dir) === 0) {
        $allowed = true;
        break;
    }
}

if (!$allowed) {
    http_response_code(403);
    die('Directory not allowed');
}

$filePath = __DIR__ . '/public/' . $file;

if (!file_exists($filePath)) {
    http_response_code(404);
    die('File not found: ' . $filePath);
}

// Get file info
$fileInfo = pathinfo($filePath);
$extension = strtolower($fileInfo['extension']);

// Set appropriate content type
$contentTypes = [
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg', 
    'png' => 'image/png',
    'gif' => 'image/gif',
    'webp' => 'image/webp'
];

if (!isset($contentTypes[$extension])) {
    http_response_code(415);
    die('Unsupported file type');
}

// Serve the image
header('Content-Type: ' . $contentTypes[$extension]);
header('Content-Length: ' . filesize($filePath));
header('Cache-Control: public, max-age=3600');

readfile($filePath);
?>
