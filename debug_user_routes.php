<?php

// Debug script untuk user routes
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DEBUGGING USER ROUTES ===\n\n";

// Test 1: Check if User model and data exists
echo "1. Checking User model and data:\n";
try {
    $users = App\Models\User::all();
    echo "   Total users: " . $users->count() . "\n";
    
    if ($users->count() > 0) {
        $firstUser = $users->first();
        echo "   First user: ID={$firstUser->id}, Name={$firstUser->name}, Email={$firstUser->email}\n";
    }
} catch (Exception $e) {
    echo "   ERROR: " . $e->getMessage() . "\n";
}

// Test 2: Check if authController show method exists
echo "\n2. Checking authController show method:\n";
try {
    $controller = new App\Http\Controllers\authController();
    if (method_exists($controller, 'show')) {
        echo "   ✅ show() method exists\n";
    } else {
        echo "   ❌ show() method NOT found\n";
    }
    
    if (method_exists($controller, 'edit')) {
        echo "   ✅ edit() method exists\n";
    } else {
        echo "   ❌ edit() method NOT found\n";
    }
    
    if (method_exists($controller, 'update')) {
        echo "   ✅ update() method exists\n";
    } else {
        echo "   ❌ update() method NOT found\n";
    }
} catch (Exception $e) {
    echo "   ERROR: " . $e->getMessage() . "\n";
}

// Test 3: Check routes directly
echo "\n3. Checking registered routes:\n";
$routes = Route::getRoutes();
$userRoutes = [];

foreach ($routes as $route) {
    $uri = $route->uri();
    if (strpos($uri, 'admin/users') !== false) {
        $userRoutes[] = [
            'method' => implode('|', $route->methods()),
            'uri' => $uri,
            'name' => $route->getName(),
            'action' => $route->getActionName()
        ];
    }
}

echo "   Found " . count($userRoutes) . " user routes:\n";
foreach ($userRoutes as $route) {
    echo "   - {$route['method']} {$route['uri']} [{$route['name']}] → {$route['action']}\n";
}

// Test 4: Try to call show method directly
echo "\n4. Testing show method directly:\n";
try {
    if ($users->count() > 0) {
        $controller = new App\Http\Controllers\authController();
        $response = $controller->show($users->first()->id);
        
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            echo "   ✅ show() method returns JSON response\n";
            echo "   Response: " . $response->getContent() . "\n";
        } else {
            echo "   ⚠️  show() method returns: " . gettype($response) . "\n";
        }
    }
} catch (Exception $e) {
    echo "   ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== DEBUG COMPLETED ===\n";

?>
