<?php
header('Content-Type: text/plain');
require_once __DIR__ . '/../includes/db.php';

$pdo = getDB();
if (!$pdo) {
    die("No DB connection available");
}

// Run queries
echo "=== SHOW TABLES ===\n";
$stmt = $pdo->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
foreach ($tables as $t) echo "  $t\n";

echo "\n=== DESCRIBE products ===\n";
$stmt = $pdo->query("DESCRIBE products");
$rows = $stmt->fetchAll();
$cols = array_keys($rows[0] ?? []);
echo implode("\t", $cols) . "\n";
foreach ($rows as $r) echo implode("\t", $r) . "\n";

echo "\n=== DESCRIBE categories ===\n";
$stmt = $pdo->query("DESCRIBE categories");
$rows = $stmt->fetchAll();
echo implode("\t", array_keys($rows[0] ?? [])) . "\n";
foreach ($rows as $r) echo implode("\t", $r) . "\n";

echo "\n=== EXISTING PRODUCTS ===\n";
$stmt = $pdo->query("SELECT id, title, slug FROM products ORDER BY id");
while ($r = $stmt->fetch()) echo "{$r['id']}\t{$r['title']}\t{$r['slug']}\n";

echo "\n=== EXISTING CATEGORIES ===\n";
$stmt = $pdo->query("SELECT id, name, slug FROM categories ORDER BY id");
while ($r = $stmt->fetch()) echo "{$r['id']}\t{$r['name']}\t{$r['slug']}\n";
