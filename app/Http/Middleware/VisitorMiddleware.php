<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\VisitorService;
use Symfony\Component\HttpFoundation\Response;

class VisitorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking for certain routes
        if ($this->shouldSkipTracking($request)) {
            return $next($request);
        }
        
        // Track visitor asynchronously to avoid slowing down the response
        try {
            VisitorService::trackVisitor($request);
        } catch (\Exception $e) {
            // Log error but don't break the application
            \Log::error('Visitor middleware error: ' . $e->getMessage());
        }

        return $next($request);
    }
    
    /**
     * Determine if visitor tracking should be skipped for this request
     */
    private function shouldSkipTracking(Request $request): bool
    {
        // Skip for AJAX requests
        if ($request->ajax()) {
            return true;
        }
        
        // Skip for API routes
        if ($request->is('api/*')) {
            return true;
        }
        
        // Skip for admin asset requests
        if ($request->is('assets/*') || $request->is('css/*') || $request->is('js/*') || $request->is('images/*')) {
            return true;
        }
        
        // Skip for favicon and robots.txt
        if ($request->is('favicon.ico') || $request->is('robots.txt')) {
            return true;
        }
        
        // Skip for bots and crawlers
        $userAgent = $request->userAgent();
        $botPatterns = [
            'bot', 'crawler', 'spider', 'scraper', 
            'googlebot', 'bingbot', 'yahoobot', 'facebookexternalhit'
        ];
        
        foreach ($botPatterns as $pattern) {
            if (stripos($userAgent, $pattern) !== false) {
                return true;
            }
        }
        
        return false;
    }
}
