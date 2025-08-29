<?php
// Debug script untuk memastikan admin modern berfungsi
echo "<h1>🔍 Admin Modern Debug Check</h1>";

// Check Laravel
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
    echo "✅ Laravel autoload: OK<br>";
} else {
    echo "❌ Laravel autoload: NOT FOUND<br>";
}

// Check files
$files_to_check = [
    'resources/views/layout/admin-modern.blade.php',
    'resources/views/admin/dashboard-modern.blade.php', 
    'resources/views/admin/content/manage-modern.blade.php',
    'resources/views/admin/gallery/manage-modern.blade.php',
    'resources/views/admin/users/manage-modern.blade.php',
    'public/css/admin-modern-components.css',
    'public/js/admin-modern.js'
];

echo "<h2>📁 File Check:</h2>";
foreach ($files_to_check as $file) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "✅ {$file}: EXISTS<br>";
    } else {
        echo "❌ {$file}: NOT FOUND<br>";
    }
}

// Check routes
echo "<h2>🛣️ Routes Check:</h2>";
echo "Try accessing these URLs:<br>";
echo "• <a href='/admin/dashboard' target='_blank'>/admin/dashboard</a> (should redirect to modern)<br>";
echo "• <a href='/admin/dashboard-modern' target='_blank'>/admin/dashboard-modern</a> (direct modern)<br>";
echo "• <a href='/admin/content/manage' target='_blank'>/admin/content/manage</a> (should redirect)<br>";
echo "• <a href='/admin/gallery' target='_blank'>/admin/gallery</a> (should redirect)<br>";
echo "• <a href='/admin/users-modern' target='_blank'>/admin/users-modern</a> (direct modern)<br>";

// Check assets
echo "<h2>🎨 Assets Check:</h2>";
$css_path = __DIR__ . '/public/css/admin-modern-components.css';
$js_path = __DIR__ . '/public/js/admin-modern.js';

if (file_exists($css_path)) {
    $css_size = filesize($css_path);
    echo "✅ CSS File: {$css_size} bytes<br>";
} else {
    echo "❌ CSS File: NOT FOUND<br>";
}

if (file_exists($js_path)) {
    $js_size = filesize($js_path);
    echo "✅ JS File: {$js_size} bytes<br>";
} else {
    echo "❌ JS File: NOT FOUND<br>";
}

// Check .env
echo "<h2>⚙️ Environment Check:</h2>";
if (file_exists(__DIR__ . '/.env')) {
    echo "✅ .env file: EXISTS<br>";
    $env_content = file_get_contents(__DIR__ . '/.env');
    if (strpos($env_content, 'APP_DEBUG=true') !== false) {
        echo "✅ Debug mode: ENABLED<br>";
    } else {
        echo "⚠️ Debug mode: DISABLED<br>";
    }
} else {
    echo "❌ .env file: NOT FOUND<br>";
}

// Check permissions
echo "<h2>🔐 Permissions Check:</h2>";
$dirs_to_check = ['storage', 'bootstrap/cache', 'public'];
foreach ($dirs_to_check as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (is_dir($path) && is_writable($path)) {
        echo "✅ {$dir}: WRITABLE<br>";
    } else {
        echo "❌ {$dir}: NOT WRITABLE<br>";
    }
}

echo "<hr>";
echo "<h2>📝 Troubleshooting Steps:</h2>";
echo "1. Ensure you've pulled the latest changes from git<br>";
echo "2. Run: <code>php artisan cache:clear</code><br>";
echo "3. Run: <code>php artisan config:clear</code><br>";  
echo "4. Run: <code>php artisan route:clear</code><br>";
echo "5. Check file permissions (755 for folders, 644 for files)<br>";
echo "6. Try accessing the direct modern URLs listed above<br>";
echo "7. Check browser console for any JavaScript errors<br>";
echo "8. Verify your web server (Apache/Nginx) configuration<br>";

echo "<hr>";
echo "<p><strong>Note:</strong> If you still don't see changes, try hard refresh (Ctrl+F5) or clear browser cache.</p>";
?>
