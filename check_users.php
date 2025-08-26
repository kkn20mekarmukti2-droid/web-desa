<?php
// Check user accounts and roles

echo "=== CHECKING USER ACCOUNTS ===\n";
$pdo = new PDO('sqlite:database/database.sqlite');

echo "\n� First, let's check table structure:\n";
$stmt = $pdo->query('PRAGMA table_info(users)');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "📋 Column: {$row['name']} | Type: {$row['type']} | NotNull: {$row['notnull']}\n";
}

echo "\n�📊 All Users in Database:\n";
$stmt = $pdo->query('SELECT * FROM users ORDER BY id');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "👤 ID: {$row['id']} | Name: {$row['name']} | Email: {$row['email']}\n";
    foreach ($row as $key => $value) {
        if (!in_array($key, ['id', 'name', 'email'])) {
            echo "   - {$key}: {$value}\n";
        }
    }
}

echo "\n📋 Available Roles:\n";
$stmt = $pdo->query('SELECT DISTINCT role FROM users');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "🏷️  Role: {$row['role']}\n";
}

echo "\n📈 User Statistics:\n";
$stmt = $pdo->query('SELECT role, COUNT(*) as count FROM users GROUP BY role');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "📊 {$row['role']}: {$row['count']} users\n";
}

echo "\n🔍 Let's also check table structure:\n";
$stmt = $pdo->query('PRAGMA table_info(users)');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "📋 Column: {$row['name']} | Type: {$row['type']} | NotNull: {$row['notnull']}\n";
}
?>
