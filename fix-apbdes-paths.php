<?php
header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['action'])) {
        throw new Exception('Invalid request');
    }
    
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    switch ($input['action']) {
        case 'update':
            $id = $input['id'];
            $newPath = $input['path'];
            
            $stmt = $pdo->prepare("UPDATE apbdes SET image_path = ? WHERE id = ?");
            $stmt->execute([$newPath, $id]);
            
            echo json_encode(['success' => true, 'message' => "Path updated for record ID $id"]);
            break;
            
        case 'fix_all':
            // Get all records that need fixing
            $stmt = $pdo->query("SELECT id, image_path FROM apbdes WHERE image_path NOT LIKE 'img/apbdes/%'");
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $updated = 0;
            foreach ($records as $record) {
                $oldPath = $record['image_path'];
                
                // Convert different path formats to img/apbdes/
                if (strpos($oldPath, 'apbdes/') === 0) {
                    // Laravel storage format: "apbdes/filename.jpg" -> "img/apbdes/filename.jpg"
                    $newPath = 'img/apbdes/' . basename($oldPath);
                } else {
                    // Other formats: extract filename and use correct path
                    $newPath = 'img/apbdes/' . basename($oldPath);
                }
                
                $updateStmt = $pdo->prepare("UPDATE apbdes SET image_path = ? WHERE id = ?");
                $updateStmt->execute([$newPath, $record['id']]);
                $updated++;
            }
            
            echo json_encode(['success' => true, 'message' => "Fixed $updated records to use img/apbdes/ path format"]);
            break;
            
        default:
            throw new Exception('Unknown action');
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
