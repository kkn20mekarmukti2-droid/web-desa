<?php
/**
 * Create Visitor Counter Database Tables
 */

echo "🗄️ === CREATING VISITOR COUNTER TABLES === 🗄️\n\n";

try {
    // Connect to SQLite database
    $pdo = new PDO("sqlite:" . __DIR__ . "/database/database.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Database connection established\n";
    
    // Read SQL file
    $sql = file_get_contents(__DIR__ . '/visitor-counter-tables.sql');
    
    // Split SQL into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)), function($stmt) {
        return !empty($stmt) && !preg_match('/^--/', $stmt);
    });
    
    echo "📋 Executing " . count($statements) . " SQL statements...\n\n";
    
    foreach ($statements as $index => $statement) {
        if (empty(trim($statement))) continue;
        
        try {
            $pdo->exec($statement);
            
            // Determine what was executed
            if (strpos($statement, 'CREATE TABLE') !== false) {
                preg_match('/CREATE TABLE IF NOT EXISTS (\w+)/', $statement, $matches);
                $tableName = $matches[1] ?? 'unknown';
                echo "✅ Created table: {$tableName}\n";
            } elseif (strpos($statement, 'CREATE INDEX') !== false) {
                preg_match('/CREATE INDEX IF NOT EXISTS (\w+)/', $statement, $matches);
                $indexName = $matches[1] ?? 'unknown';
                echo "✅ Created index: {$indexName}\n";
            } elseif (strpos($statement, 'INSERT') !== false) {
                echo "✅ Inserted initial data\n";
            }
        } catch (PDOException $e) {
            echo "❌ Error executing statement " . ($index + 1) . ": " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n🔍 **VERIFYING TABLES CREATED:**\n";
    
    // Verify tables were created
    $tables = ['visitor_stats', 'visitor_logs', 'visitors_online', 'popular_pages'];
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='{$table}'");
        $exists = $stmt->rowCount() > 0;
        echo "  - {$table}: " . ($exists ? "✅ Created" : "❌ Missing") . "\n";
        
        if ($exists) {
            // Count columns
            $stmt = $pdo->query("PRAGMA table_info({$table})");
            $columns = $stmt->fetchAll();
            echo "    └─ Columns: " . count($columns) . "\n";
        }
    }
    
    echo "\n📊 **INITIAL DATA CHECK:**\n";
    
    // Check if initial data exists
    $stmt = $pdo->query("SELECT * FROM visitor_stats WHERE date = DATE('now')");
    $todayStats = $stmt->fetch();
    
    if ($todayStats) {
        echo "✅ Today's stats initialized:\n";
        echo "  - Date: {$todayStats['date']}\n";
        echo "  - Total visitors: {$todayStats['total_visitors']}\n";
        echo "  - Unique visitors: {$todayStats['unique_visitors']}\n";
        echo "  - Page views: {$todayStats['page_views']}\n";
    }
    
    echo "\n🎉 **VISITOR COUNTER TABLES SETUP COMPLETE!** 🎉\n";
    echo "Database is ready for visitor tracking implementation.\n\n";
    
    echo "📝 **NEXT STEPS:**\n";
    echo "1. Create VisitorMiddleware for auto-tracking\n";
    echo "2. Create VisitorService for business logic\n";
    echo "3. Add visitor counter to footer\n";
    echo "4. Create admin dashboard for analytics\n\n";
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>
