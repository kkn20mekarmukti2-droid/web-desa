<?php
/**
 * Simple Visitor API for Website Footer
 * Access via: /visitor-api.php
 */

// Set proper headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Include Laravel classes manually
require_once __DIR__ . '/app/Services/VisitorService.php';

try {
    $action = $_GET['action'] ?? 'stats';
    
    switch ($action) {
        case 'stats':
            $stats = \App\Services\VisitorService::getStats();
            break;
            
        case 'track':
            // Track visitor
            $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
            $page = $_GET['page'] ?? '/';
            
            \App\Services\VisitorService::trackVisitor($ip, $userAgent, $page);
            $stats = \App\Services\VisitorService::getStats();
            break;
            
        default:
            throw new Exception('Invalid action');
    }
    
    $response = [
        'success' => true,
        'data' => $stats,
        'timestamp' => date('c')
    ];
    
    echo json_encode($response);
    
} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => $e->getMessage(),
        'timestamp' => date('c')
    ];
    
    http_response_code(500);
    echo json_encode($response);
}
?>
