<?php
/**
 * Custom Streetwear - Database Update Installer
 * This script only adds missing columns, won't duplicate existing tables/columns
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'custitty_wafa');
define('DB_USER', 'custitty_wafa');
define('DB_PASS', 'Wafa@4052364');

// Security: Comment this line after running once
$allow_run = true;

if (!$allow_run) {
    die('Installation already completed. Remove this file for security.');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Installer</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; background: #0a0a0a; color: #fff; padding: 40px 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        h1 { font-size: 28px; margin-bottom: 30px; }
        .card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 8px; padding: 30px; margin-bottom: 20px; }
        .success { color: #4ade80; }
        .error { color: #f87171; }
        .info { color: #60a5fa; }
        .warning { color: #fbbf24; }
        .btn { display: inline-block; padding: 12px 24px; background: #3b82f6; color: #fff; text-decoration: none; border-radius: 6px; border: none; cursor: pointer; font-size: 16px; }
        .btn:hover { background: #2563eb; }
        pre { background: #0a0a0a; padding: 15px; border-radius: 6px; overflow-x: auto; margin: 10px 0; font-size: 13px; }
        .step { margin: 15px 0; padding: 15px; background: #0f0f0f; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Database Update Installer</h1>
        
        <?php
        if (isset($_POST['run_install'])) {
            echo '<div class="card">';
            
            try {
                // Connect to database
                $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo '<div class="step success">✓ Connected to database</div>';
                
                // Check and add columns to pages table
                echo '<div class="step info">→ Checking pages table...</div>';
                
                $result = $conn->query("SHOW COLUMNS FROM pages LIKE 'seo_title'");
                if ($result->rowCount() == 0) {
                    $conn->exec("ALTER TABLE pages ADD COLUMN seo_title VARCHAR(255) DEFAULT NULL AFTER short_description");
                    echo '<div class="step success">✓ Added seo_title column to pages table</div>';
                } else {
                    echo '<div class="step warning">⊙ Column seo_title already exists</div>';
                }
                
                $result = $conn->query("SHOW COLUMNS FROM pages LIKE 'seo_description'");
                if ($result->rowCount() == 0) {
                    $conn->exec("ALTER TABLE pages ADD COLUMN seo_description TEXT DEFAULT NULL AFTER seo_title");
                    echo '<div class="step success">✓ Added seo_description column to pages table</div>';
                } else {
                    echo '<div class="step warning">⊙ Column seo_description already exists</div>';
                }
                
                $result = $conn->query("SHOW COLUMNS FROM pages LIKE 'meta_keywords'");
                if ($result->rowCount() == 0) {
                    $conn->exec("ALTER TABLE pages ADD COLUMN meta_keywords TEXT DEFAULT NULL AFTER seo_description");
                    echo '<div class="step success">✓ Added meta_keywords column to pages table</div>';
                } else {
                    echo '<div class="step warning">⊙ Column meta_keywords already exists</div>';
                }
                
                // Update existing data
                $conn->exec("UPDATE pages SET seo_title = title WHERE seo_title IS NULL OR seo_title = ''");
                $conn->exec("UPDATE pages SET seo_description = short_description WHERE seo_description IS NULL OR seo_description = ''");
                echo '<div class="step success">✓ Updated existing pages with SEO data</div>';
                
                // Check and add cover_image to categories table
                echo '<div class="step info">→ Checking categories table...</div>';
                
                $result = $conn->query("SHOW COLUMNS FROM categories LIKE 'cover_image'");
                if ($result->rowCount() == 0) {
                    $conn->exec("ALTER TABLE categories ADD COLUMN cover_image VARCHAR(255) DEFAULT NULL AFTER image");
                    echo '<div class="step success">✓ Added cover_image column to categories table</div>';
                } else {
                    echo '<div class="step warning">⊙ Column cover_image already exists</div>';
                }
                
                echo '<div class="step success" style="margin-top:30px;font-size:18px;">✓ Installation completed successfully!</div>';
                echo '<div class="step info">Next steps:<br>1. Delete this install.php file<br>2. Clear browser cache<br>3. Login to admin panel</div>';
                
            } catch (PDOException $e) {
                echo '<div class="step error">✗ Database Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
            
            echo '</div>';
        } else {
            ?>
            <div class="card">
                <h2 style="margin-bottom:20px;">Ready to Install Database Updates</h2>
                <p style="margin-bottom:20px; line-height:1.6;">This installer will add the following columns:</p>
                <ul style="margin-bottom:20px; line-height:1.8; margin-left:20px;">
                    <li><strong>pages</strong> table: seo_title, seo_description, meta_keywords</li>
                    <li><strong>categories</strong> table: cover_image</li>
                </ul>
                <p style="margin-bottom:20px; line-height:1.6; color:#fbbf24;">
                    ⚠️ <strong>Important:</strong> This script is safe. It only adds missing columns and will not duplicate existing columns or delete any data.
                </p>
                <form method="POST">
                    <button type="submit" name="run_install" class="btn">Run Installation</button>
                </form>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>
