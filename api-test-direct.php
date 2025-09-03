<?php
/**
 * Simple Visitor API Test - Direct Access
 */

// Set proper headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Include Laravel bootstrap
require_once __DIR__ . '/vendor/autoload.php';

use App\Services\VisitorService;

try {
    // Test VisitorService directly
    $stats = VisitorService::getStats();
    
    $response = [
        'success' => true,
        'data' => $stats,
        'timestamp' => date('c'),
        'message' => 'Direct API test successful'
    ];
    
    echo json_encode($response, JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => $e->getMessage(),
        'timestamp' => date('c')
    ];
    
    http_response_code(500);
    echo json_encode($response, JSON_PRETTY_PRINT);
}
?>
