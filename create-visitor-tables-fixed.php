<?php
/**
 * Create Visitor Counter Database Tables - Fixed Version
 */

echo "🗄️ === CREATING VISITOR COUNTER TABLES (FIXED) === 🗄️\n\n";

try {
    // Connect to SQLite database
    $pdo = new PDO("sqlite:" . __DIR__ . "/database/database.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Database connection established\n\n";
    
    // Define tables with their SQL
    $tables = [
        'visitor_stats' => "
            CREATE TABLE IF NOT EXISTS visitor_stats (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                date DATE NOT NULL UNIQUE,
                total_visitors INTEGER DEFAULT 0,
                unique_visitors INTEGER DEFAULT 0,
                page_views INTEGER DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
        
        'visitor_logs' => "
            CREATE TABLE IF NOT EXISTS visitor_logs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                ip_address VARCHAR(45) NOT NULL,
                user_agent TEXT,
                page_url VARCHAR(500) NOT NULL,
                referer_url VARCHAR(500),
                session_id VARCHAR(100),
                is_unique_today BOOLEAN DEFAULT 0,
                browser VARCHAR(50),
                device VARCHAR(50),
                country VARCHAR(50),
                city VARCHAR(100),
                visit_duration INTEGER DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
        
        'visitors_online' => "
            CREATE TABLE IF NOT EXISTS visitors_online (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                session_id VARCHAR(100) NOT NULL UNIQUE,
                ip_address VARCHAR(45) NOT NULL,
                user_agent TEXT,
                page_url VARCHAR(500) NOT NULL,
                last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
        
        'popular_pages' => "
            CREATE TABLE IF NOT EXISTS popular_pages (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                page_url VARCHAR(500) NOT NULL,
                page_title VARCHAR(200),
                visit_count INTEGER DEFAULT 1,
                last_visited TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                UNIQUE(page_url)
            )
        "
    ];
    
    // Create tables
    foreach ($tables as $tableName => $sql) {
        try {
            $pdo->exec($sql);
            echo "✅ Created table: {$tableName}\n";
        } catch (PDOException $e) {
            echo "❌ Error creating {$tableName}: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n📊 Creating indexes...\n";
    
    // Create indexes
    $indexes = [
        "CREATE INDEX IF NOT EXISTS idx_visitor_logs_ip_date ON visitor_logs(ip_address, date(created_at))",
        "CREATE INDEX IF NOT EXISTS idx_visitor_logs_session ON visitor_logs(session_id)",
        "CREATE INDEX IF NOT EXISTS idx_visitors_online_session ON visitors_online(session_id)",
        "CREATE INDEX IF NOT EXISTS idx_visitors_online_activity ON visitors_online(last_activity)",
        "CREATE INDEX IF NOT EXISTS idx_popular_pages_url ON popular_pages(page_url)",
        "CREATE INDEX IF NOT EXISTS idx_visitor_stats_date ON visitor_stats(date)"
    ];
    
    foreach ($indexes as $indexSql) {
        try {
            $pdo->exec($indexSql);
            preg_match('/CREATE INDEX IF NOT EXISTS (\w+)/', $indexSql, $matches);
            $indexName = $matches[1] ?? 'unknown';
            echo "✅ Created index: {$indexName}\n";
        } catch (PDOException $e) {
            echo "❌ Error creating index: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n📋 Inserting initial data...\n";
    
    // Insert initial data for today
    try {
        $pdo->exec("INSERT OR IGNORE INTO visitor_stats (date, total_visitors, unique_visitors, page_views) VALUES (DATE('now'), 0, 0, 0)");
        echo "✅ Inserted today's initial stats\n";
    } catch (PDOException $e) {
        echo "❌ Error inserting initial data: " . $e->getMessage() . "\n";
    }
    
    echo "\n🔍 **VERIFYING TABLES CREATED:**\n";
    
    // Verify tables were created
    foreach (array_keys($tables) as $table) {
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
    } else {
        echo "❌ Today's stats not found\n";
    }
    
    echo "\n🎉 **VISITOR COUNTER TABLES SETUP COMPLETE!** 🎉\n";
    echo "Database is ready for visitor tracking implementation.\n\n";
    
    echo "📝 **TABLES CREATED:**\n";
    echo "1. visitor_stats - Daily summary statistics\n";
    echo "2. visitor_logs - Detailed visitor logs\n";
    echo "3. visitors_online - Real-time online users\n";
    echo "4. popular_pages - Most visited pages tracking\n\n";
    
    echo "🚀 **READY FOR NEXT STEP: Create VisitorService & Middleware**\n";
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>
