<?php
/**
 * Manual visitor stats update
 */

// Connect to database
$dbPath = __DIR__ . '/database/database.sqlite';
if (!file_exists($dbPath)) {
    $dbPath = $_SERVER['DOCUMENT_ROOT'] . '/web-desa/database/database.sqlite';
}

try {
    $pdo = new PDO("sqlite:" . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $today = date('Y-m-d');
    
    // Count today's visitors
    $stmt = $pdo->prepare("SELECT COUNT(*) as total_visits FROM visitor_logs WHERE DATE(created_at) = ?");
    $stmt->execute([$today]);
    $totalVisits = $stmt->fetch(PDO::FETCH_ASSOC)['total_visits'];
    
    // Count unique visitors today
    $stmt = $pdo->prepare("SELECT COUNT(DISTINCT ip_address) as unique_visitors FROM visitor_logs WHERE DATE(created_at) = ?");
    $stmt->execute([$today]);
    $uniqueVisitors = $stmt->fetch(PDO::FETCH_ASSOC)['unique_visitors'];
    
    // Count page views today
    $pageViews = $totalVisits; // Each visit is a page view
    
    echo "Today's actual data:\n";
    echo "- Total visits: $totalVisits\n";
    echo "- Unique visitors: $uniqueVisitors\n";
    echo "- Page views: $pageViews\n\n";
    
    // Update or insert today's stats
    $stmt = $pdo->prepare("SELECT * FROM visitor_stats WHERE date = ?");
    $stmt->execute([$today]);
    $existingStats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existingStats) {
        // Update existing stats
        $stmt = $pdo->prepare("UPDATE visitor_stats SET total_visitors = ?, unique_visitors = ?, page_views = ?, updated_at = ? WHERE date = ?");
        $stmt->execute([$totalVisits, $uniqueVisitors, $pageViews, date('Y-m-d H:i:s'), $today]);
        echo "Stats updated for today!\n";
    } else {
        // Insert new stats
        $stmt = $pdo->prepare("INSERT INTO visitor_stats (date, total_visitors, unique_visitors, page_views, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$today, $totalVisits, $uniqueVisitors, $pageViews, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
        echo "New stats created for today!\n";
    }
    
    // Show updated stats
    echo "\nUpdated visitor stats:\n";
    $stmt = $pdo->prepare("SELECT * FROM visitor_stats WHERE date = ?");
    $stmt->execute([$today]);
    $updatedStats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($updatedStats) {
        echo "Date: {$updatedStats['date']}\n";
        echo "Total visitors: {$updatedStats['total_visitors']}\n";
        echo "Unique visitors: {$updatedStats['unique_visitors']}\n";
        echo "Page views: {$updatedStats['page_views']}\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
