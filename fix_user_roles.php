<?php
// Add missing columns to users table

echo "=== ADDING MISSING COLUMNS TO USERS TABLE ===\n";
$pdo = new PDO('sqlite:database/database.sqlite');

// Check current user structure 
echo "Current user data:\n";
$stmt = $pdo->query('SELECT * FROM users LIMIT 1');
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user) {
    foreach ($user as $key => $value) {
        echo "- $key: $value\n";
    }
}

// Try to add role column if missing
echo "\nAttempting to add role column...\n";
try {
    $pdo->exec('ALTER TABLE users ADD COLUMN role INTEGER DEFAULT 1');
    echo "✅ Added role column successfully!\n";
} catch (Exception $e) {
    echo "❌ Role column might already exist: " . $e->getMessage() . "\n";
}

// Try to add foto column if missing
echo "\nAttempting to add foto column...\n";  
try {
    $pdo->exec('ALTER TABLE users ADD COLUMN foto TEXT DEFAULT NULL');
    echo "✅ Added foto column successfully!\n";
} catch (Exception $e) {
    echo "❌ Foto column might already exist: " . $e->getMessage() . "\n";
}

// Set admin user role to 0 (admin)
echo "\nSetting Admin user role to 0 (admin)...\n";
try {
    $stmt = $pdo->prepare('UPDATE users SET role = 0 WHERE email = ?');
    $stmt->execute(['admin@webdesa.com']);
    echo "✅ Admin user role set to 0 (admin)!\n";
} catch (Exception $e) {
    echo "❌ Failed to update admin role: " . $e->getMessage() . "\n";
}

// Check final result
echo "\nFinal user data:\n";
$stmt = $pdo->query('PRAGMA table_info(users)');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "📋 Column: {$row['name']} | Type: {$row['type']} | Default: {$row['dflt_value']}\n";
}

echo "\nCurrent users:\n";
$stmt = $pdo->query('SELECT id, name, email, role FROM users');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $roleText = $row['role'] == 0 ? 'Admin' : ($row['role'] == 1 ? 'Writer' : 'Unknown');
    echo "👤 {$row['name']} | {$row['email']} | Role: {$row['role']} ($roleText)\n";
}
?>
