<?php
require_once __DIR__ . '/config/config.php';
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->prepare("SELECT LEFT(full_description, 200) as raw_desc FROM products WHERE id = ?");
    $stmt->execute([1]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "RAW DB value (first 200 chars):\n";
    echo $row['raw_desc'] . "\n\n";
    echo "After htmlspecialchars_decode:\n";
    echo htmlspecialchars_decode($row['raw_desc'], ENT_QUOTES) . "\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
