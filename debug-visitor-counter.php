<?php
/**
 * Debug Visitor Counter System
 */

echo "🔍 === DEBUGGING VISITOR COUNTER SYSTEM === 🔍\n\n";

try {
    // Test database connection
    $pdo = new PDO("sqlite:" . __DIR__ . "/database/database.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Database connection successful\n";
    
    // Check current data in tables
    echo "\n📊 **CURRENT DATABASE STATE:**\n";
    
    // Check visitor_stats
    $stmt = $pdo->query("SELECT * FROM visitor_stats ORDER BY date DESC LIMIT 5");
    $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "visitor_stats table (" . count($stats) . " records):\n";
    foreach ($stats as $stat) {
        echo "  - {$stat['date']}: Total={$stat['total_visitors']}, Unique={$stat['unique_visitors']}, Views={$stat['page_views']}\n";
    }
    
    // Check visitor_logs
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM visitor_logs");
    $logsCount = $stmt->fetch()['count'];
    echo "\nvisitor_logs table: {$logsCount} records\n";
    
    if ($logsCount > 0) {
        $stmt = $pdo->query("SELECT * FROM visitor_logs ORDER BY created_at DESC LIMIT 3");
        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Recent logs:\n";
        foreach ($logs as $log) {
            echo "  - {$log['ip_address']} visited {$log['page_url']} at {$log['created_at']}\n";
        }
    }
    
    // Check visitors_online
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM visitors_online WHERE last_activity >= datetime('now', '-5 minutes')");
    $onlineCount = $stmt->fetch()['count'];
    echo "\nvisitors_online (last 5 min): {$onlineCount} users\n";
    
    // Check popular_pages
    $stmt = $pdo->query("SELECT * FROM popular_pages ORDER BY visit_count DESC LIMIT 3");
    $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "\npopular_pages table (" . count($pages) . " records):\n";
    foreach ($pages as $page) {
        echo "  - {$page['page_url']}: {$page['visit_count']} visits\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n🔧 **CHECKING SYSTEM CONFIGURATION:**\n";

// Check if middleware is registered
echo "\n1. Checking middleware registration...\n";
$bootstrapContent = file_get_contents(__DIR__ . '/bootstrap/app.php');
if (strpos($bootstrapContent, 'VisitorMiddleware') !== false) {
    echo "✅ VisitorMiddleware is registered\n";
} else {
    echo "❌ VisitorMiddleware NOT registered\n";
}

// Check if routes are configured
echo "\n2. Checking routes configuration...\n";
$routesContent = file_get_contents(__DIR__ . '/routes/web.php');
if (strpos($routesContent, 'visitor-stats') !== false) {
    echo "✅ Visitor API routes are configured\n";
} else {
    echo "❌ Visitor API routes NOT configured\n";
}

if (strpos($routesContent, "middleware(['visitor'])") !== false) {
    echo "✅ Visitor middleware group is configured\n";
} else {
    echo "❌ Visitor middleware group NOT configured\n";
}

// Check if VisitorService exists
echo "\n3. Checking VisitorService...\n";
if (file_exists(__DIR__ . '/app/Services/VisitorService.php')) {
    echo "✅ VisitorService.php exists\n";
} else {
    echo "❌ VisitorService.php NOT found\n";
}

echo "\n🧪 **TESTING VISITOR TRACKING MANUALLY:**\n";

// Simulate a visitor tracking call
echo "\nSimulating visitor tracking...\n";

// Create a test visitor entry
try {
    $today = date('Y-m-d');
    $now = date('Y-m-d H:i:s');
    
    // Insert test visitor log
    $stmt = $pdo->prepare("INSERT INTO visitor_logs (ip_address, user_agent, page_url, session_id, is_unique_today, browser, device, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        '192.168.1.' . rand(1, 255), // Random IP
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/91.0',
        'http://localhost/test-page',
        'test_session_' . uniqid(),
        1, // Unique today
        'Chrome',
        'Desktop',
        $now
    ]);
    echo "✅ Test visitor log inserted\n";
    
    // Update visitor stats
    $stmt = $pdo->prepare("INSERT OR REPLACE INTO visitor_stats (date, total_visitors, unique_visitors, page_views, updated_at) VALUES (?, ?, ?, ?, ?)");
    
    // Get current stats
    $currentStats = $pdo->query("SELECT * FROM visitor_stats WHERE date = '{$today}'")->fetch(PDO::FETCH_ASSOC);
    
    if ($currentStats) {
        $newTotal = $currentStats['total_visitors'] + 1;
        $newUnique = $currentStats['unique_visitors'] + 1;
        $newViews = $currentStats['page_views'] + 1;
    } else {
        $newTotal = 1;
        $newUnique = 1;
        $newViews = 1;
    }
    
    $stmt->execute([$today, $newTotal, $newUnique, $newViews, $now]);
    echo "✅ Visitor stats updated: Total={$newTotal}, Unique={$newUnique}, Views={$newViews}\n";
    
    // Update online visitors
    $stmt = $pdo->prepare("INSERT OR REPLACE INTO visitors_online (session_id, ip_address, user_agent, page_url, last_activity) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(['test_online_' . uniqid(), '192.168.1.100', 'Test Browser', 'http://localhost/', $now]);
    echo "✅ Online visitor updated\n";
    
} catch (PDOException $e) {
    echo "❌ Error in manual tracking test: " . $e->getMessage() . "\n";
}

echo "\n📈 **FINAL VERIFICATION:**\n";

// Check updated stats
try {
    $stmt = $pdo->query("SELECT * FROM visitor_stats WHERE date = '{$today}'");
    $finalStats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($finalStats) {
        echo "✅ Today's final stats:\n";
        echo "   - Total visitors: {$finalStats['total_visitors']}\n";
        echo "   - Unique visitors: {$finalStats['unique_visitors']}\n";
        echo "   - Page views: {$finalStats['page_views']}\n";
    } else {
        echo "❌ No stats found for today\n";
    }
    
    // Check online count
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM visitors_online WHERE last_activity >= datetime('now', '-5 minutes')");
    $finalOnline = $stmt->fetch()['count'];
    echo "   - Online now: {$finalOnline}\n";
    
} catch (PDOException $e) {
    echo "❌ Error checking final stats: " . $e->getMessage() . "\n";
}

echo "\n🎯 **DIAGNOSIS & RECOMMENDATIONS:**\n";

if ($logsCount == 0) {
    echo "🔴 **MAIN ISSUE**: No visitor logs are being created!\n";
    echo "   This means the VisitorMiddleware is not working.\n\n";
    echo "   **FIXES NEEDED:**\n";
    echo "   1. Ensure visitor middleware is applied to routes\n";
    echo "   2. Check if Laravel autoload is updated\n";
    echo "   3. Clear Laravel cache if any\n";
    echo "   4. Verify database permissions\n";
} else {
    echo "✅ Visitor logging is working\n";
}

echo "\n📋 **NEXT STEPS:**\n";
echo "1. Run: composer dump-autoload\n";
echo "2. Check if middleware is properly applied to routes\n";
echo "3. Test API endpoints directly\n";
echo "4. Verify JavaScript is loading on frontend\n\n";

echo "Debug completed at " . date('Y-m-d H:i:s') . "\n";
?>
