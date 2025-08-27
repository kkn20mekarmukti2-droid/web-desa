<?php
// Clean up users table and create only Admin and Writer with specific IDs

echo "=== CLEANING UP USERS TABLE ===\n";
$pdo = new PDO('sqlite:database/database.sqlite');

// Show current users
echo "Current users before cleanup:\n";
$stmt = $pdo->query('SELECT id, name, email, role FROM users ORDER BY id');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $roleText = $row['role'] == 0 ? 'Admin' : 'Writer';
    echo "👤 ID: {$row['id']} | {$row['name']} | {$row['email']} | Role: {$row['role']} ($roleText)\n";
}

// Delete all existing users
echo "\nDeleting all existing users...\n";
try {
    $pdo->exec('DELETE FROM users');
    echo "✅ All users deleted successfully!\n";
} catch (Exception $e) {
    echo "❌ Failed to delete users: " . $e->getMessage() . "\n";
}

// Reset the auto increment counter
echo "Resetting auto increment...\n";
try {
    $pdo->exec('DELETE FROM sqlite_sequence WHERE name = "users"');
    echo "✅ Auto increment reset!\n";
} catch (Exception $e) {
    echo "❌ Failed to reset auto increment: " . $e->getMessage() . "\n";
}

// Create Admin user with ID 4
echo "Creating Admin user with ID 4...\n";
try {
    $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        4, // Specific ID
        'Admin',
        'admin@webdesa.com',
        $hashedPassword,
        0, // Admin role
        date('Y-m-d H:i:s'),
        date('Y-m-d H:i:s')
    ]);
    echo "✅ Admin user created with ID 4!\n";
} catch (Exception $e) {
    echo "❌ Failed to create admin: " . $e->getMessage() . "\n";
}

// Create Writer user with ID 5  
echo "Creating Writer user with ID 5...\n";
try {
    $hashedPassword = password_hash('writer123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        5, // Specific ID
        'Writer',
        'writer@webdesa.com',
        $hashedPassword,
        1, // Writer role
        date('Y-m-d H:i:s'),
        date('Y-m-d H:i:s')
    ]);
    echo "✅ Writer user created with ID 5!\n";
} catch (Exception $e) {
    echo "❌ Failed to create writer: " . $e->getMessage() . "\n";
}

// Update auto increment to continue from ID 6
echo "Setting next auto increment to 6...\n";
try {
    $pdo->exec('UPDATE sqlite_sequence SET seq = 5 WHERE name = "users"');
    echo "✅ Auto increment set to continue from 6!\n";
} catch (Exception $e) {
    echo "❌ Failed to set auto increment: " . $e->getMessage() . "\n";
}

// Show final result
echo "\n📊 FINAL USERS:\n";
$stmt = $pdo->query('SELECT id, name, email, role, created_at FROM users ORDER BY id');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $roleText = match($row['role']) {
        0 => '👑 Admin (Full Access)',
        1 => '✍️  Writer (Own Content Only)',
        default => '❓ Unknown'
    };
    echo "👤 ID: {$row['id']} | {$row['name']} | {$row['email']}\n";
    echo "   {$roleText}\n";
    echo "   📅 Created: {$row['created_at']}\n\n";
}

echo "🔐 LOGIN CREDENTIALS:\n";
echo "Admin: admin@webdesa.com / admin123 (ID: 4)\n";
echo "Writer: writer@webdesa.com / writer123 (ID: 5)\n";

echo "\n✅ Database cleanup completed successfully!\n";
echo "Only 2 users remain with specific IDs as requested.\n";
?>
