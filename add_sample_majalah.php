<?php

require_once 'check_database.php';

// Sample data untuk majalah
$sampleMajalah = [
    [
        'judul' => 'Majalah Desa Edisi Januari 2024',
        'url' => 'majalah-januari-2024.jpg',
        'type' => 'cover',
        'created_by' => 'Admin Desa'
    ],
    [
        'judul' => 'Buletin Desa Edisi Februari 2024',
        'url' => 'buletin-februari-2024.jpg',
        'type' => 'cover',
        'created_by' => 'Admin Desa'
    ],
    [
        'judul' => 'Info Desa Edisi Maret 2024',
        'url' => 'info-desa-maret-2024.jpg',
        'type' => 'cover',
        'created_by' => 'Admin Desa'
    ]
];

echo "🔄 Menambahkan sample majalah...\n";

try {
    foreach ($sampleMajalah as $majalah) {
        // Check if already exists
        $check = $pdo->prepare("SELECT id FROM majalah WHERE judul = ?");
        $check->execute([$majalah['judul']]);
        
        if (!$check->fetch()) {
            // Insert new majalah
            $stmt = $pdo->prepare("
                INSERT INTO majalah (judul, url, type, created_by, created_at, updated_at) 
                VALUES (?, ?, ?, ?, NOW(), NOW())
            ");
            
            if ($stmt->execute([
                $majalah['judul'],
                $majalah['url'],
                $majalah['type'],
                $majalah['created_by']
            ])) {
                echo "✅ Berhasil menambahkan: {$majalah['judul']}\n";
            }
        } else {
            echo "⚠️  Sudah ada: {$majalah['judul']}\n";
        }
    }
    
    // Create placeholder images
    echo "\n🖼️  Membuat placeholder images...\n";
    $placeholderImages = [
        'majalah-januari-2024.jpg',
        'buletin-februari-2024.jpg',
        'info-desa-maret-2024.jpg'
    ];
    
    foreach ($placeholderImages as $filename) {
        $publicPath = "public/majalah/$filename";
        $galeriPath = "public/galeri/$filename";
        
        if (!file_exists($publicPath) && !file_exists($galeriPath)) {
            // Create a simple colored placeholder
            $width = 400;
            $height = 600;
            $image = imagecreate($width, $height);
            
            // Random colors for each cover
            $colors = [
                [52, 144, 220], // Blue
                [46, 204, 113], // Green  
                [155, 89, 182]  // Purple
            ];
            
            $colorIndex = array_search($filename, $placeholderImages);
            $color = $colors[$colorIndex % count($colors)];
            
            $bg = imagecolorallocate($image, $color[0], $color[1], $color[2]);
            $white = imagecolorallocate($image, 255, 255, 255);
            
            // Add text
            $title = str_replace(['-', '.jpg'], [' ', ''], $filename);
            $title = ucwords($title);
            
            // Simple text (imagettftext would need font file)
            imagestring($image, 5, 50, 250, $title, $white);
            imagestring($image, 3, 100, 300, 'Desa Digital', $white);
            imagestring($image, 2, 120, 350, '2024', $white);
            
            // Try to save in both locations
            if (!is_dir('public/majalah')) {
                mkdir('public/majalah', 0755, true);
            }
            
            if (imagejpeg($image, $publicPath, 80)) {
                echo "✅ Created: $publicPath\n";
            } else {
                // Fallback to galeri folder
                if (imagejpeg($image, $galeriPath, 80)) {
                    echo "✅ Created (in galeri): $galeriPath\n";
                }
            }
            
            imagedestroy($image);
        } else {
            if (file_exists($publicPath)) {
                echo "⚠️  Already exists: $publicPath\n";
            } else {
                echo "⚠️  Already exists: $galeriPath\n";
            }
        }
    }
    
    echo "\n📊 Status database majalah:\n";
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM majalah");
    $total = $stmt->fetch()['total'];
    echo "Total majalah: $total\n";
    
    $stmt = $pdo->query("SELECT judul, url, type, created_at FROM majalah ORDER BY created_at DESC LIMIT 5");
    echo "\nMajalah terbaru:\n";
    while ($row = $stmt->fetch()) {
        echo "- {$row['judul']} ({$row['type']}) - {$row['created_at']}\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n✅ Sample majalah berhasil ditambahkan!\n";
?>
