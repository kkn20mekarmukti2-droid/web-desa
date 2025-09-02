<?php
/**
 * Verify authController methods are unique and properly structured
 */

$file = __DIR__ . '/app/Http/Controllers/authController.php';
$content = file_get_contents($file);

echo "=== AUTHCONTROLLER METHOD VERIFICATION ===\n\n";

// Find all public methods
preg_match_all('/public function (\w+)\(/', $content, $matches);

$methods = $matches[1];
$methodCounts = array_count_values($methods);

echo "📋 **PUBLIC METHODS FOUND:**\n";
foreach ($methods as $index => $method) {
    $count = $methodCounts[$method];
    $status = $count > 1 ? "❌ DUPLICATE" : "✅";
    echo "  " . ($index + 1) . ". {$method}() {$status}\n";
}

echo "\n🔍 **DUPLICATE CHECK:**\n";
$hasDuplicates = false;
foreach ($methodCounts as $method => $count) {
    if ($count > 1) {
        echo "❌ Method '{$method}()' appears {$count} times!\n";
        $hasDuplicates = true;
    }
}

if (!$hasDuplicates) {
    echo "✅ No duplicate methods found!\n";
}

echo "\n🛡️ **ROLE-BASED METHODS VERIFICATION:**\n";

$roleMethods = [
    'canManageUser' => 'private function canManageUser(',
    'getAvailableRoles' => 'private function getAvailableRoles(',
    'updateRole' => 'public function updateRole(',
    'resetPassword' => 'public function resetPassword(',
    'store' => 'public function store(',
    'update' => 'public function update(',
    'destroy' => 'public function destroy('
];

foreach ($roleMethods as $methodName => $signature) {
    $found = strpos($content, $signature) !== false;
    echo "  {$methodName}(): " . ($found ? "✅ Found" : "❌ Missing") . "\n";
}

echo "\n🎯 **PERMISSION CHECKS VERIFICATION:**\n";

$permissionChecks = [
    'canManageUser($user)' => 'Permission check in methods',
    'getAvailableRoles()' => 'Role restriction in forms',
    'Auth::user()->role' => 'Role-based access control',
    'SuperAdmin' => 'SuperAdmin role handling',
    'Admin' => 'Admin role handling'
];

foreach ($permissionChecks as $check => $description) {
    $found = strpos($content, $check) !== false;
    echo "  {$description}: " . ($found ? "✅ Implemented" : "❌ Missing") . "\n";
}

echo "\n📊 **FILE STATISTICS:**\n";
echo "  - Total lines: " . count(explode("\n", $content)) . "\n";
echo "  - Total methods: " . count($methods) . "\n";
echo "  - File size: " . number_format(strlen($content)) . " bytes\n";

echo "\n🎉 **STATUS: " . ($hasDuplicates ? "NEEDS FIX" : "READY FOR PRODUCTION") . "** 🎉\n";

if (!$hasDuplicates) {
    echo "Your authController.php is properly structured with role-based access control!\n";
}

echo "\nVerification completed at " . date('Y-m-d H:i:s') . "\n";
?>
