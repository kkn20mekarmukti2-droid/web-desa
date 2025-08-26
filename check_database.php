<?php
// Check user accounts and database tables

echo "=== CHECKING USER ACCOUNTS & DATABASE ===\n";
$pdo = new PDO('sqlite:database/database.sqlite');

echo "\n🔍 Users Table Structure:\n";
$stmt = $pdo->query('PRAGMA table_info(users)');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "📋 Column: {$row['name']} | Type: {$row['type']} | NotNull: {$row['notnull']}\n";
}

echo "\n👥 All Users in Database:\n";
$stmt = $pdo->query('SELECT id, name, email, created_at, updated_at FROM users ORDER BY id');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "👤 ID: {$row['id']}\n";
    echo "   📛 Name: {$row['name']}\n";
    echo "   📧 Email: {$row['email']}\n"; 
    echo "   📅 Created: {$row['created_at']}\n";
    echo "   🔄 Updated: {$row['updated_at']}\n\n";
}

echo "📊 User Count: ";
$stmt = $pdo->query('SELECT COUNT(*) as count FROM users');
$count = $stmt->fetch(PDO::FETCH_ASSOC);
echo "{$count['count']} users\n\n";

echo "🗃️  Available Tables in Database:\n";
$stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "📁 Table: {$row['name']}\n";
}

echo "\n💡 Notes:\n";
echo "- No 'role' column found in users table\n";
echo "- Only basic Laravel authentication structure exists\n";
echo "- Admin user exists: admin@webdesa.com\n";
?>
