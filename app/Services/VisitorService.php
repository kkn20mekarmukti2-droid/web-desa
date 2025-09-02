<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class VisitorService
{
    /**
     * Track a visitor to the website
     */
    public static function trackVisitor($request = null)
    {
        if (!$request) {
            $request = request();
        }
        
        $sessionId = session()->getId();
        $ipAddress = self::getClientIP();
        $userAgent = $request->userAgent();
        $pageUrl = $request->fullUrl();
        $refererUrl = $request->header('referer');
        
        // Check if this is a unique visitor today
        $isUniqueToday = self::isUniqueVisitorToday($ipAddress);
        
        // Get browser and device info
        $browserInfo = self::parseBrowserInfo($userAgent);
        
        try {
            // Insert visitor log
            DB::table('visitor_logs')->insert([
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'page_url' => $pageUrl,
                'referer_url' => $refererUrl,
                'session_id' => $sessionId,
                'is_unique_today' => $isUniqueToday ? 1 : 0,
                'browser' => $browserInfo['browser'],
                'device' => $browserInfo['device'],
                'created_at' => now(),
            ]);
            
            // Update visitor stats for today
            self::updateDailyStats($isUniqueToday);
            
            // Update online visitors
            self::updateOnlineVisitors($sessionId, $ipAddress, $userAgent, $pageUrl);
            
            // Update popular pages
            self::updatePopularPages($pageUrl, self::getPageTitle($request));
            
            return true;
            
        } catch (\Exception $e) {
            // Log error but don't break the application
            \Log::error('Visitor tracking error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Check if visitor is unique for today
     */
    private static function isUniqueVisitorToday($ipAddress)
    {
        $today = date('Y-m-d');
        
        $existing = DB::table('visitor_logs')
            ->where('ip_address', $ipAddress)
            ->whereDate('created_at', $today)
            ->first();
            
        return $existing === null;
    }
    
    /**
     * Update daily statistics
     */
    private static function updateDailyStats($isUniqueToday)
    {
        $today = date('Y-m-d');
        
        // Get or create today's stats
        $stats = DB::table('visitor_stats')->where('date', $today)->first();
        
        if ($stats) {
            // Update existing stats
            DB::table('visitor_stats')
                ->where('date', $today)
                ->increment('page_views', 1);
                
            if ($isUniqueToday) {
                DB::table('visitor_stats')
                    ->where('date', $today)
                    ->increment('unique_visitors', 1);
            }
            
            // Always increment total visitors for page views
            DB::table('visitor_stats')
                ->where('date', $today)
                ->increment('total_visitors', 1);
        } else {
            // Create new stats record
            DB::table('visitor_stats')->insert([
                'date' => $today,
                'total_visitors' => 1,
                'unique_visitors' => $isUniqueToday ? 1 : 0,
                'page_views' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    
    /**
     * Update online visitors table
     */
    private static function updateOnlineVisitors($sessionId, $ipAddress, $userAgent, $pageUrl)
    {
        // Remove old entries (older than 5 minutes)
        DB::table('visitors_online')
            ->where('last_activity', '<', now()->subMinutes(5))
            ->delete();
        
        // Update or insert current visitor
        DB::table('visitors_online')->updateOrInsert(
            ['session_id' => $sessionId],
            [
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'page_url' => $pageUrl,
                'last_activity' => now(),
                'created_at' => now(),
            ]
        );
    }
    
    /**
     * Update popular pages
     */
    private static function updatePopularPages($pageUrl, $pageTitle = null)
    {
        // Clean URL (remove query parameters for better grouping)
        $cleanUrl = strtok($pageUrl, '?');
        
        DB::table('popular_pages')->updateOrInsert(
            ['page_url' => $cleanUrl],
            [
                'page_title' => $pageTitle,
                'last_visited' => now(),
            ]
        );
        
        // Increment visit count
        DB::table('popular_pages')
            ->where('page_url', $cleanUrl)
            ->increment('visit_count', 1);
    }
    
    /**
     * Get visitor statistics
     */
    public static function getStats()
    {
        $today = date('Y-m-d');
        
        // Get today's stats
        $todayStats = DB::table('visitor_stats')
            ->where('date', $today)
            ->first();
        
        // Get total all time visitors
        $totalStats = DB::table('visitor_stats')
            ->selectRaw('SUM(total_visitors) as total_all_time')
            ->selectRaw('SUM(unique_visitors) as unique_all_time')
            ->selectRaw('SUM(page_views) as pageviews_all_time')
            ->first();
        
        // Get current online visitors
        $onlineCount = DB::table('visitors_online')
            ->where('last_activity', '>=', now()->subMinutes(5))
            ->count();
        
        return [
            'today' => [
                'total' => $todayStats->total_visitors ?? 0,
                'unique' => $todayStats->unique_visitors ?? 0,
                'page_views' => $todayStats->page_views ?? 0,
            ],
            'all_time' => [
                'total' => $totalStats->total_all_time ?? 0,
                'unique' => $totalStats->unique_all_time ?? 0,
                'page_views' => $totalStats->pageviews_all_time ?? 0,
            ],
            'online_now' => $onlineCount,
        ];
    }
    
    /**
     * Get popular pages
     */
    public static function getPopularPages($limit = 10)
    {
        return DB::table('popular_pages')
            ->orderBy('visit_count', 'desc')
            ->limit($limit)
            ->get();
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
