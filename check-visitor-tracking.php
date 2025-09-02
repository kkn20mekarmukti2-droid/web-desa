<?php
/**
 * Check if visitor tracking is actually working
 */

// Connect to database
$dbPath = __DIR__ . '/database/database.sqlite';
if (!file_exists($dbPath)) {
    $dbPath = $_SERVER['DOCUMENT_ROOT'] . '/web-desa/database/database.sqlite';
}

try {
    $pdo = new PDO("sqlite:" . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== VISITOR LOGS ===\n";
    $stmt = $pdo->query("SELECT * FROM visitor_logs ORDER BY created_at DESC LIMIT 10");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "IP: {$row['ip_address']}, Page: {$row['page_url']}, Time: {$row['created_at']}\n";
    }
    
    echo "\n=== VISITOR STATS ===\n";
    $stmt = $pdo->query("SELECT * FROM visitor_stats ORDER BY date DESC LIMIT 5");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Date: {$row['date']}, Total: {$row['total_visitors']}, Unique: {$row['unique_visitors']}, Views: {$row['page_views']}\n";
    }
    
    echo "\n=== TODAY'S COUNT ===\n";
    $today = date('Y-m-d');
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM visitor_logs WHERE DATE(created_at) = ?");
    $stmt->execute([$today]);
    $todayCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "Today's visitor logs: $todayCount\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
