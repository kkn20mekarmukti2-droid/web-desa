<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class VisitorService
{
    /**
     * Track a visitor to the website - Simplified version
     */
    public static function trackVisitor($ipAddress = null, $userAgent = null, $pageUrl = '/')
    {
        // Use provided parameters or get from globals
        $ipAddress = $ipAddress ?: ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');
        $userAgent = $userAgent ?: ($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown');
        $sessionId = session_id() ?: 'simple-session-' . uniqid();
        
        // Check if this is a unique visitor today
        $isUniqueToday = self::isUniqueVisitorToday($ipAddress);
        
        try {
            // Use absolute path for database
            $dbPath = __DIR__ . '/../../database/database.sqlite';
            if (!file_exists($dbPath)) {
                // Try alternative path
                $dbPath = $_SERVER['DOCUMENT_ROOT'] . '/web-desa/database/database.sqlite';
            }
            
            $pdo = new \PDO("sqlite:" . $dbPath);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            // Insert visitor log
            $stmt = $pdo->prepare("INSERT INTO visitor_logs (ip_address, user_agent, page_url, session_id, is_unique_today, created_at) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $ipAddress,
                $userAgent,
                $pageUrl,
                $sessionId,
                $isUniqueToday ? 1 : 0,
                date('Y-m-d H:i:s'),
            ]);
            
            // Update online visitors
            $stmt = $pdo->prepare("INSERT OR REPLACE INTO visitors_online (ip_address, last_activity) VALUES (?, ?)");
            $stmt->execute([$ipAddress, date('Y-m-d H:i:s')]);
            
            // Update daily stats
            self::updateDailyStats($isUniqueToday, $pdo);
            self::updateDailyStats($isUniqueToday, $pdo);
            
            // Update online visitors
            self::updateOnlineVisitors($sessionId, $ipAddress, $userAgent, $pageUrl, $pdo);
            
            // Update popular pages
            self::updatePopularPages($pageUrl, self::getPageTitle($request), $pdo);
            
            return true;
            
        } catch (\Exception $e) {
            // Log error but don't break the application
            error_log('Visitor tracking error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Check if visitor is unique for today
     */
    private static function isUniqueVisitorToday($ipAddress)
    {
        $today = date('Y-m-d');
        
        try {
            // Use absolute path for database
            $dbPath = __DIR__ . '/../../database/database.sqlite';
            if (!file_exists($dbPath)) {
                // Try alternative path
                $dbPath = $_SERVER['DOCUMENT_ROOT'] . '/web-desa/database/database.sqlite';
            }
            
            $pdo = new \PDO("sqlite:" . $dbPath);
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM visitor_logs WHERE ip_address = ? AND DATE(created_at) = ?");
            $stmt->execute([$ipAddress, $today]);
            $count = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
            
            return $count == 0;
        } catch (\Exception $e) {
            return true; // Assume unique if error
        }
    }
    
    /**
     * Update daily statistics
     */
    private static function updateDailyStats($isUniqueToday, $pdo = null)
    {
        $today = date('Y-m-d');
        $now = date('Y-m-d H:i:s');
        
        if (!$pdo) {
            // Use absolute path for database
            $dbPath = __DIR__ . '/../../database/database.sqlite';
            if (!file_exists($dbPath)) {
                // Try alternative path
                $dbPath = $_SERVER['DOCUMENT_ROOT'] . '/web-desa/database/database.sqlite';
            }
            
            $pdo = new \PDO("sqlite:" . $dbPath);
        }
        
        // Get or create today's stats
        $stmt = $pdo->prepare("SELECT * FROM visitor_stats WHERE date = ?");
        $stmt->execute([$today]);
        $stats = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($stats) {
            // Update existing stats
            $newTotal = $stats['total_visitors'] + 1;
            $newUnique = $stats['unique_visitors'] + ($isUniqueToday ? 1 : 0);
            $newViews = $stats['page_views'] + 1;
            
            $stmt = $pdo->prepare("UPDATE visitor_stats SET total_visitors = ?, unique_visitors = ?, page_views = ?, updated_at = ? WHERE date = ?");
            $stmt->execute([$newTotal, $newUnique, $newViews, $now, $today]);
        } else {
            // Create new stats record
            $stmt = $pdo->prepare("INSERT INTO visitor_stats (date, total_visitors, unique_visitors, page_views, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $today,
                1,
                $isUniqueToday ? 1 : 0,
                1,
                $now,
                $now
            ]);
        }
    }
    
    /**
     * Update online visitors table
     */
    private static function updateOnlineVisitors($sessionId, $ipAddress, $userAgent, $pageUrl, $pdo = null)
    {
        if (!$pdo) {
            $pdo = new \PDO("sqlite:" . database_path('database.sqlite'));
        }
        
        $now = date('Y-m-d H:i:s');
        $fiveMinutesAgo = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        
        // Remove old entries (older than 5 minutes)
        $stmt = $pdo->prepare("DELETE FROM visitors_online WHERE last_activity < ?");
        $stmt->execute([$fiveMinutesAgo]);
        
        // Update or insert current visitor
        $stmt = $pdo->prepare("INSERT OR REPLACE INTO visitors_online (session_id, ip_address, user_agent, page_url, last_activity, created_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$sessionId, $ipAddress, $userAgent, $pageUrl, $now, $now]);
    }
    
    /**
     * Update popular pages
     */
    private static function updatePopularPages($pageUrl, $pageTitle = null, $pdo = null)
    {
        if (!$pdo) {
            $pdo = new \PDO("sqlite:" . database_path('database.sqlite'));
        }
        
        // Clean URL (remove query parameters for better grouping)
        $cleanUrl = strtok($pageUrl, '?');
        $now = date('Y-m-d H:i:s');
        
        // Check if page exists
        $stmt = $pdo->prepare("SELECT visit_count FROM popular_pages WHERE page_url = ?");
        $stmt->execute([$cleanUrl]);
        $existing = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($existing) {
            // Update existing page
            $newCount = $existing['visit_count'] + 1;
            $stmt = $pdo->prepare("UPDATE popular_pages SET visit_count = ?, last_visited = ? WHERE page_url = ?");
            $stmt->execute([$newCount, $now, $cleanUrl]);
        } else {
            // Insert new page
            $stmt = $pdo->prepare("INSERT INTO popular_pages (page_url, page_title, visit_count, last_visited, created_at) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$cleanUrl, $pageTitle, 1, $now, $now]);
        }
    }
    
    /**
     * Get visitor statistics
     */
    public static function getStats()
    {
        try {
            // Use absolute path for database
            $dbPath = __DIR__ . '/../../database/database.sqlite';
            if (!file_exists($dbPath)) {
                // Try alternative path
                $dbPath = $_SERVER['DOCUMENT_ROOT'] . '/web-desa/database/database.sqlite';
            }
            
            $pdo = new \PDO("sqlite:" . $dbPath);
            $today = date('Y-m-d');
            
            // Get today's stats
            $stmt = $pdo->prepare("SELECT * FROM visitor_stats WHERE date = ?");
            $stmt->execute([$today]);
            $todayStats = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            // Get total all time visitors
            $stmt = $pdo->prepare("SELECT SUM(total_visitors) as total_all_time, SUM(unique_visitors) as unique_all_time, SUM(page_views) as pageviews_all_time FROM visitor_stats");
            $stmt->execute();
            $totalStats = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            // Get current online visitors
            $fiveMinutesAgo = date('Y-m-d H:i:s', strtotime('-5 minutes'));
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM visitors_online WHERE last_activity >= ?");
            $stmt->execute([$fiveMinutesAgo]);
            $onlineCount = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
            
            return [
                'today' => [
                    'total' => $todayStats['total_visitors'] ?? 0,
                    'unique' => $todayStats['unique_visitors'] ?? 0,
                    'page_views' => $todayStats['page_views'] ?? 0,
                ],
                'all_time' => [
                    'total' => $totalStats['total_all_time'] ?? 0,
                    'unique' => $totalStats['unique_all_time'] ?? 0,
                    'page_views' => $totalStats['pageviews_all_time'] ?? 0,
                ],
                'online_now' => $onlineCount,
            ];
        } catch (\Exception $e) {
            // Return default values on error
            return [
                'today' => ['total' => 0, 'unique' => 0, 'page_views' => 0],
                'all_time' => ['total' => 0, 'unique' => 0, 'page_views' => 0],
                'online_now' => 0,
            ];
        }
    }
    
    /**
     * Get popular pages
     */
    public static function getPopularPages($limit = 10)
    {
        try {
            $pdo = new \PDO("sqlite:" . database_path('database.sqlite'));
            $stmt = $pdo->prepare("SELECT * FROM popular_pages ORDER BY visit_count DESC LIMIT ?");
            $stmt->execute([$limit]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return [];
        }
    }
    
    /**
     * Get client IP address
     */
    private static function getClientIP()
    {
        $ipKeys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
        
        foreach ($ipKeys as $key) {
            if (!empty($_SERVER[$key])) {
                $ip = $_SERVER[$key];
                if (strpos($ip, ',') !== false) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
    
    /**
     * Parse browser and device info from user agent
     */
    private static function parseBrowserInfo($userAgent)
    {
        $browser = 'Unknown';
        $device = 'Desktop';
        
        // Detect browser
        if (strpos($userAgent, 'Chrome') !== false) {
            $browser = 'Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            $browser = 'Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            $browser = 'Safari';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            $browser = 'Edge';
        } elseif (strpos($userAgent, 'Opera') !== false) {
            $browser = 'Opera';
        }
        
        // Detect device
        if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Android') !== false) {
            $device = 'Mobile';
        } elseif (strpos($userAgent, 'Tablet') !== false || strpos($userAgent, 'iPad') !== false) {
            $device = 'Tablet';
        }
        
        return [
            'browser' => $browser,
            'device' => $device,
        ];
    }
    
    /**
     * Get page title from request
     */
    private static function getPageTitle($request)
    {
        $path = $request->path();
        
        // Define page titles based on routes
        $pageTitles = [
            '/' => 'Beranda',
            'tentang' => 'Tentang Desa',
            'berita' => 'Berita',
            'pengaduan' => 'Pengaduan',
            'umkm' => 'UMKM',
            'apbdes' => 'APBDes',
            'admin' => 'Dashboard Admin',
            'login' => 'Login',
        ];
        
        foreach ($pageTitles as $route => $title) {
            if (strpos($path, $route) !== false) {
                return $title;
            }
        }
        
        return 'Web Desa';
    }
}
