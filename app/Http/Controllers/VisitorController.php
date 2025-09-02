<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VisitorService;
use Illuminate\Http\JsonResponse;

class VisitorController extends Controller
{
    /**
     * Get current visitor statistics
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = VisitorService::getStats();
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'timestamp' => now()->toISOString(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving visitor stats',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Get popular pages
     */
    public function getPopularPages(Request $request): JsonResponse
    {
        try {
            $limit = $request->get('limit', 10);
            $pages = VisitorService::getPopularPages($limit);
            
            return response()->json([
                'success' => true,
                'data' => $pages,
                'timestamp' => now()->toISOString(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving popular pages',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Get visitor statistics for admin dashboard
     */
    public function getDashboardStats(): JsonResponse
    {
        try {
            $stats = VisitorService::getStats();
            $popularPages = VisitorService::getPopularPages(5);
            
            // Get last 7 days statistics
            $last7Days = \DB::table('visitor_stats')
                ->select('date', 'total_visitors', 'unique_visitors', 'page_views')
                ->where('date', '>=', now()->subDays(7)->format('Y-m-d'))
                ->orderBy('date', 'asc')
                ->get();
            
            // Get browser statistics
            $browserStats = \DB::table('visitor_logs')
                ->select('browser', \DB::raw('count(*) as count'))
                ->whereDate('created_at', today())
                ->groupBy('browser')
                ->orderBy('count', 'desc')
                ->limit(5)
                ->get();
            
            // Get device statistics
            $deviceStats = \DB::table('visitor_logs')
                ->select('device', \DB::raw('count(*) as count'))
                ->whereDate('created_at', today())
                ->groupBy('device')
                ->orderBy('count', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'current_stats' => $stats,
                    'popular_pages' => $popularPages,
                    'last_7_days' => $last7Days,
                    'browser_stats' => $browserStats,
                    'device_stats' => $deviceStats,
                ],
                'timestamp' => now()->toISOString(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving dashboard stats',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
