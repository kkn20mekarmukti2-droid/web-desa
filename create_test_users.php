<?php
// Create test users with different roles

echo "=== CREATING TEST USERS ===\n";
$pdo = new PDO('sqlite:database/database.sqlite');

// Create Writer user
echo "Creating Writer user...\n";
try {
    $hashedPassword = password_hash('writer123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        'Writer Desa',
        'writer@webdesa.com', 
        $hashedPassword,
        1, // Writer role
        date('Y-m-d H:i:s'),
        date('Y-m-d H:i:s')
    ]);
    echo "✅ Writer user created successfully!\n";
} catch (Exception $e) {
    echo "❌ Writer user might already exist: " . $e->getMessage() . "\n";
}

// Create another test user
echo "Creating Editor user...\n";
try {
    $hashedPassword = password_hash('editor123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        'Editor Desa',
        'editor@webdesa.com',
        $hashedPassword, 
        1, // Writer role (same as writer for now)
        date('Y-m-d H:i:s'),
        date('Y-m-d H:i:s')
    ]);
    echo "✅ Editor user created successfully!\n";
} catch (Exception $e) {
    echo "❌ Editor user might already exist: " . $e->getMessage() . "\n";
}

// Display all users
echo "\n📊 ALL USERS IN SYSTEM:\n";
$stmt = $pdo->query('SELECT id, name, email, role, created_at FROM users ORDER BY id');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $roleText = match($row['role']) {
        0 => '👑 Super Admin',
        1 => '✍️  Writer/Editor',
        default => '❓ Unknown'
    };
    echo "👤 ID: {$row['id']} | {$row['name']} | {$row['email']} | {$roleText}\n";
    echo "   📅 Created: {$row['created_at']}\n\n";
}

echo "🔐 LOGIN CREDENTIALS:\n";
echo "Admin: admin@webdesa.com / admin123\n";
echo "Writer: writer@webdesa.com / writer123\n"; 
echo "Editor: editor@webdesa.com / editor123\n";

echo "\n💡 ROLE SYSTEM:\n";
echo "- Role 0: Super Admin (can see all content, full access)\n";
echo "- Role 1: Writer/Editor (can only see own content)\n";
?>
