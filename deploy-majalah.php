<?php
/**
 * CPanel Web Deployment Script untuk Sistem Majalah
 * Website Desa Mekarmukti
 * 
 * Akses: yoursite.com/deploy-majalah.php
 */

// Security check
$allowed_ips = ['127.0.0.1', '::1']; // Add your IP here for production
if (!in_array($_SERVER['REMOTE_ADDR'], $allowed_ips) && !isset($_GET['force'])) {
    die('Access denied. Add ?force=1 to bypass (not recommended for production)');
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Majalah System Deployment</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .success { color: green; background: #f0f8f0; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: red; background: #f8f0f0; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { color: blue; background: #f0f0f8; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .step { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        code { background: #f5f5f5; padding: 2px 5px; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>🚀 Magazine System Deployment</h1>
    <p>Website Desa Mekarmukti - Digital Magazine System</p>

<?php
if (isset($_POST['deploy'])) {
    echo "<h2>📊 Deployment Progress:</h2>";
    
    // Step 1: Check requirements
    echo "<div class='step'>";
    echo "<h3>1. Checking Requirements</h3>";
    
    $requirements_ok = true;
    
    if (extension_loaded('pdo_mysql')) {
        echo "<div class='success'>✅ PDO MySQL extension loaded</div>";
    } else {
        echo "<div class='error'>❌ PDO MySQL extension not found</div>";
        $requirements_ok = false;
    }
    
    if (extension_loaded('gd')) {
        echo "<div class='success'>✅ GD extension loaded (for image processing)</div>";
    } else {
        echo "<div class='error'>❌ GD extension not found</div>";
        $requirements_ok = false;
    }
    
    if (is_writable('storage')) {
        echo "<div class='success'>✅ Storage directory is writable</div>";
    } else {
        echo "<div class='error'>❌ Storage directory is not writable</div>";
        $requirements_ok = false;
    }
    
    echo "</div>";
    
    if (!$requirements_ok) {
        echo "<div class='error'>❌ Requirements not met. Please fix the issues above.</div>";
        exit;
    }
    
    // Step 2: Database operations
    echo "<div class='step'>";
    echo "<h3>2. Database Setup</h3>";
    
    try {
        // Load environment variables
        if (file_exists('.env')) {
            $env = file_get_contents('.env');
            preg_match('/DB_HOST=(.*)/', $env, $host_match);
            preg_match('/DB_DATABASE=(.*)/', $env, $db_match);
            preg_match('/DB_USERNAME=(.*)/', $env, $user_match);
            preg_match('/DB_PASSWORD=(.*)/', $env, $pass_match);
            
            $host = isset($host_match[1]) ? trim($host_match[1]) : 'localhost';
            $database = isset($db_match[1]) ? trim($db_match[1]) : 'web_desa';
            $username = isset($user_match[1]) ? trim($user_match[1]) : 'root';
            $password = isset($pass_match[1]) ? trim($pass_match[1]) : '';
        } else {
            throw new Exception('.env file not found');
        }
        
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Read and execute SQL script
        $sql_content = file_get_contents('majalah-tables-deployment.sql');
        
        // Split by semicolon and execute each statement
        $statements = array_filter(array_map('trim', explode(';', $sql_content)));
        
        foreach ($statements as $statement) {
            if (!empty($statement) && !preg_match('/^\s*--/', $statement)) {
                $pdo->exec($statement);
            }
        }
        
        echo "<div class='success'>✅ Database tables created successfully</div>";
        
        // Verify tables
        $result = $pdo->query("SHOW TABLES LIKE 'majalah%'");
        $tables = $result->fetchAll(PDO::FETCH_COLUMN);
        
        if (in_array('majalah', $tables) && in_array('majalah_pages', $tables)) {
            echo "<div class='success'>✅ Tables verified: majalah, majalah_pages</div>";
        } else {
            throw new Exception('Tables not created properly');
        }
        
    } catch (Exception $e) {
        echo "<div class='error'>❌ Database error: " . $e->getMessage() . "</div>";
        exit;
    }
    
    echo "</div>";
    
    // Step 3: Directory structure
    echo "<div class='step'>";
    echo "<h3>3. Storage Directories</h3>";
    
    $directories = [
        'storage/app/public/majalah',
        'storage/app/public/majalah/pages'
    ];
    
    foreach ($directories as $dir) {
        if (!is_dir($dir)) {
            if (mkdir($dir, 0755, true)) {
                echo "<div class='success'>✅ Created directory: $dir</div>";
            } else {
                echo "<div class='error'>❌ Failed to create directory: $dir</div>";
            }
        } else {
            echo "<div class='info'>ℹ️ Directory already exists: $dir</div>";
        }
    }
    
    echo "</div>";
    
    // Step 4: Permissions
    echo "<div class='step'>";
    echo "<h3>4. File Permissions</h3>";
    
    if (chmod('storage', 0755)) {
        echo "<div class='success'>✅ Storage permissions set</div>";
    } else {
        echo "<div class='error'>❌ Failed to set storage permissions</div>";
    }
    
    if (is_dir('storage/app/public/majalah') && chmod('storage/app/public/majalah', 0755)) {
        echo "<div class='success'>✅ Magazine directory permissions set</div>";
    }
    
    echo "</div>";
    
    // Step 5: Test data verification
    echo "<div class='step'>";
    echo "<h3>5. Sample Data Verification</h3>";
    
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM majalah");
        $majalah_count = $stmt->fetchColumn();
        
        $stmt = $pdo->query("SELECT COUNT(*) FROM majalah_pages");
        $pages_count = $stmt->fetchColumn();
        
        echo "<div class='success'>✅ Sample magazines created: $majalah_count</div>";
        echo "<div class='success'>✅ Sample pages created: $pages_count</div>";
        
    } catch (Exception $e) {
        echo "<div class='error'>❌ Error checking sample data: " . $e->getMessage() . "</div>";
    }
    
    echo "</div>";
    
    // Step 6: Final instructions
    echo "<div class='step'>";
    echo "<h3>🎉 Deployment Complete!</h3>";
    echo "<div class='success'>";
    echo "<h4>📋 Next Steps:</h4>";
    echo "<ol>";
    echo "<li><strong>Delete this file</strong> for security: <code>deploy-majalah.php</code></li>";
    echo "<li><strong>Admin Access:</strong> <a href='/admin/majalah' target='_blank'>/admin/majalah</a></li>";
    echo "<li><strong>Public View:</strong> <a href='/majalah-desa' target='_blank'>/majalah-desa</a></li>";
    echo "<li><strong>Upload sample images</strong> to <code>storage/app/public/majalah/</code></li>";
    echo "<li><strong>Test flipbook functionality</strong></li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<div class='info'>";
    echo "<h4>📱 Features Available:</h4>";
    echo "<ul>";
    echo "<li>✅ Full CRUD admin interface</li>";
    echo "<li>✅ Drag-drop file upload</li>";
    echo "<li>✅ Interactive flipbook reader</li>";
    echo "<li>✅ Homepage teaser integration</li>";
    echo "<li>✅ Mobile responsive design</li>";
    echo "<li>✅ Navigation menu integration</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "</div>";
    
} else {
    // Show deployment form
?>
    <div class="info">
        <h3>⚠️ Before You Start:</h3>
        <ul>
            <li>Ensure your <code>.env</code> file has correct database credentials</li>
            <li>Make sure <code>storage</code> directory is writable</li>
            <li>Have <code>majalah-tables-deployment.sql</code> file in root directory</li>
            <li>Backup your database before proceeding</li>
        </ul>
    </div>

    <div class="step">
        <h3>🚀 Ready to Deploy Magazine System?</h3>
        <p>This will create the necessary database tables and directories for the digital magazine system.</p>
        
        <form method="post">
            <button type="submit" name="deploy" style="background: #28a745; color: white; padding: 15px 30px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">
                🚀 Start Deployment
            </button>
        </form>
    </div>

    <div class="info">
        <h4>📊 What will be deployed:</h4>
        <ul>
            <li><code>majalah</code> table - Main magazine data</li>
            <li><code>majalah_pages</code> table - Magazine pages data</li>
            <li>Storage directories for images</li>
            <li>Sample data for testing</li>
            <li>Proper file permissions</li>
        </ul>
    </div>
<?php
}
?>
</body>
</html>
