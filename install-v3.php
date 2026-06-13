<?php
/**
 * Custom Streetwear v3 - Ultimate Installer
 * This script combines and executes ALL available SQL files in the directory.
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

$success = '';
$error = '';
$logs = [];
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

// Database defaults
$db = [
    'host' => 'localhost',
    'name' => 'custitty_wafa',
    'user' => 'custitty_wafa',
    'pass' => 'Wafa@4052364',
];

// SQL Files to import in specific order if possible
$sqlFiles = [
    'database.sql',
    'master.sql',
    'custitty_wafa.sql',
    'migration-new-tables.sql',
    'migration-homepage-v3.sql',
    'migration-v2-seo-settings.sql',
    'migration-homepage-settings.sql',
    'csw-products-import.sql',
    'csw-images-to-webp.sql'
];

// Add any other .sql files found in directory
$allFiles = glob(__DIR__ . '/*.sql');
foreach ($allFiles as $file) {
    $filename = basename($file);
    if (!in_array($filename, $sqlFiles)) {
        $sqlFiles[] = $filename;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db['host'] = trim($_POST['db_host'] ?? 'localhost');
    $db['name'] = trim($_POST['db_name'] ?? '');
    $db['user'] = trim($_POST['db_user'] ?? '');
    $db['pass'] = $_POST['db_pass'] ?? '';

    if (isset($_POST['test_connection'])) {
        try {
            $dsn = "mysql:host={$db['host']};charset=utf8mb4";
            $pdo = new PDO($dsn, $db['user'], $db['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $success = 'Connection Successful! You can now proceed to import all tables.';
            $step = 2;
        } catch (PDOException $e) {
            $error = 'Connection Failed: ' . $e->getMessage();
        }
    }

    if (isset($_POST['import_sql'])) {
        try {
            $dsn = "mysql:host={$db['host']};charset=utf8mb4";
            $pdo = new PDO($dsn, $db['user'], $db['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            
            // Create Database
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$db['name']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `{$db['name']}`");
            
            $pdo->exec("SET NAMES utf8mb4");
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

            $totalQueries = 0;
            $filesImported = 0;

            foreach ($sqlFiles as $sqlFile) {
                $filePath = __DIR__ . '/' . $sqlFile;
                if (!file_exists($filePath)) continue;

                $sqlContent = file_get_contents($filePath);
                // Simple split by semicolon (handles most common cases)
                $sqlContent = str_replace("\r\n", "\n", $sqlContent);
                $lines = explode("\n", $sqlContent);
                $stmt = '';
                $fileQueries = 0;

                foreach ($lines as $line) {
                    $t = trim($line);
                    if ($t === '' || substr($t, 0, 2) === '--' || substr($t, 0, 1) === '#') continue;
                    $stmt .= $line . "\n";
                    if (substr($t, -1) === ';') {
                        $q = trim($stmt, " \n\r\t;");
                        if (!empty($q)) {
                            try { 
                                $pdo->exec($q); 
                                $fileQueries++;
                                $totalQueries++;
                            } catch (PDOException $e) {
                                // Log error but continue
                                $logs[] = "Error in $sqlFile: " . $e->getMessage();
                            }
                        }
                        $stmt = '';
                    }
                }
                $filesImported++;
                $logs[] = "Imported $sqlFile ($fileQueries queries)";
            }
            
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

            // Update configuration file
            $cfg = __DIR__ . '/config/config.php';
            if (file_exists($cfg)) {
                $c = file_get_contents($cfg);
                
                // Update DB Name
                $c = preg_replace("/define\('DB_NAME',\s*getenv\('CSW_DB_NAME'\)\s*\?\:\s*'[^']*'\)/", "define('DB_NAME', getenv('CSW_DB_NAME') ?: '{$db['name']}')", $c);
                // Update DB User
                $c = preg_replace("/define\('DB_USER',\s*getenv\('CSW_DB_USER'\)\s*\?\:\s*'[^']*'\)/", "define('DB_USER', getenv('CSW_DB_USER') ?: '{$db['user']}')", $c);
                // Update DB Pass
                $c = preg_replace("/define\('DB_PASS',\s*getenv\('CSW_DB_PASS'\)\s*\?\:\s*'[^']*'\)/", "define('DB_PASS', getenv('CSW_DB_PASS') ?: '{$db['pass']}')", $c);
                
                // Force site URL to current host
                $currentHost = $_SERVER['HTTP_HOST'];
                $c = preg_replace("/\\\$host\s*=\s*\$_SERVER\['HTTP_HOST'\]\s*\?\:\s*'[^']*'/", "\$host = \$_SERVER['HTTP_HOST'] ?: '{$currentHost}'", $c);

                file_put_contents($cfg, $c);
                $logs[] = "Updated config/config.php with new credentials and host: $currentHost";
            }

            // Also update site_settings table if it exists
            try {
                $pdo->exec("UPDATE site_settings SET setting_value = '{$db['name']}' WHERE setting_key = 'site_domain' OR setting_key = 'site_name' LIMIT 1");
            } catch (Exception $e) {}

            file_put_contents(__DIR__ . '/.installed', date('Y-m-d H:i:s'));
            $success = "Success! Imported $filesImported files and executed $totalQueries queries.";
            $step = 3;
        } catch (Exception $e) {
            $error = "Fatal Error: " . $e->getMessage();
            $step = 2;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ultimate Installer v3 - Custom Streetwear</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Inter', sans-serif;background:#050505;color:#e0e0e0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.box{background:#0f0f0f;border:1px solid #222;border-radius:16px;padding:40px;max-width:600px;width:100%;box-shadow:0 20px 50px rgba(0,0,0,0.5)}
h1{text-align:center;color:#39ff14;font-size:28px;margin-bottom:10px;font-weight:800;letter-spacing:-1px}
.sub{text-align:center;color:#666;font-size:14px;margin-bottom:30px;text-transform:uppercase;letter-spacing:2px}
.steps{display:flex;justify-content:center;gap:15px;margin-bottom:30px}
.s{width:45px;height:45px;border-radius:12px;background:#1a1a1a;color:#444;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:18px;transition:0.3s}
.s.a{background:#39ff14;color:#000;box-shadow:0 0 20px rgba(57,255,20,0.3)}
.s.d{background:#1a3a1a;color:#39ff14}
label{display:block;font-size:12px;font-weight:600;color:#555;margin-bottom:8px;text-transform:uppercase}
input{width:100%;padding:14px;background:#080808;border:1px solid #222;border-radius:10px;color:#fff;font-size:15px;margin-bottom:20px;transition:0.3s}
input:focus{outline:none;border-color:#39ff14;background:#0c0c0c}
.btn{width:100%;padding:16px;border:none;border-radius:10px;font-size:16px;font-weight:700;cursor:pointer;background:#39ff14;color:#000;transition:0.3s;text-transform:uppercase;letter-spacing:1px}
.btn:hover{transform:translateY(-2px);box-shadow:0 10px 20px rgba(57,255,20,0.2)}
.ok{background:rgba(57,255,20,0.1);border:1px solid #39ff14;color:#39ff14;padding:15px;border-radius:10px;margin-bottom:20px;font-size:14px;font-weight:500}
.err{background:rgba(255,57,20,0.1);border:1px solid #ff3914;color:#ff3914;padding:15px;border-radius:10px;margin-bottom:20px;font-size:14px;font-weight:500}
.log-box{background:#080808;border:1px solid #222;border-radius:10px;padding:15px;margin-top:20px;max-height:150px;overflow-y:auto;font-family:monospace;font-size:12px;color:#888}
.log-entry{margin-bottom:4px;border-bottom:1px solid #111;padding-bottom:2px}
.sql-list{margin:20px 0;background:#111;padding:15px;border-radius:10px;border:1px solid #222}
.sql-item{font-size:13px;color:#aaa;margin-bottom:5px;display:flex;align-items:center;gap:8px}
.sql-item::before{content:'';width:6px;height:6px;background:#39ff14;border-radius:50%}
.done-card{text-align:center;padding:20px 0}
.done-card h2{color:#39ff14;font-size:32px;margin-bottom:10px}
.admin-link{display:block;margin:20px 0;padding:20px;background:#111;border:1px dashed #333;border-radius:12px;text-decoration:none}
.admin-link b{color:#39ff14;display:block;margin-bottom:5px;font-size:18px}
.admin-link span{color:#666;font-size:13px}
</style>
</head>
<body>
<div class="box">
    <h1>VIPER INSTALLER</h1>
    <p class="sub">Custom Streetwear v3</p>
    
    <div class="steps">
        <div class="s <?php echo $step>=1?($step>1?'d':'a'):''; ?>">1</div>
        <div class="s <?php echo $step>=2?($step>2?'d':'a'):''; ?>">2</div>
        <div class="s <?php echo $step>=3?'d':''; ?>">3</div>
    </div>

    <?php if($success):?><div class="ok">✓ <?php echo $success?></div><?php endif?>
    <?php if($error):?><div class="err">✗ <?php echo $error?></div><?php endif?>

    <?php if($step===1):?>
        <h3 style="margin-bottom:15px;font-size:18px">Database Configuration</h3>
        <p style="color:#666;font-size:13px;margin-bottom:25px">Enter your database credentials to begin the installation.</p>
        
        <form method="POST">
            <label>Database Host</label>
            <input type="text" name="db_host" value="<?php echo htmlspecialchars($db['host'])?>" placeholder="e.g. localhost" required>
            
            <label>Database Name</label>
            <input type="text" name="db_name" value="<?php echo htmlspecialchars($db['name'])?>" placeholder="e.g. project_db" required>
            
            <label>Username</label>
            <input type="text" name="db_user" value="<?php echo htmlspecialchars($db['user'])?>" placeholder="e.g. root" required>
            
            <label>Password</label>
            <input type="password" name="db_pass" value="<?php echo htmlspecialchars($db['pass'])?>" placeholder="Database password">
            
            <button type="submit" name="test_connection" class="btn">Test & Proceed</button>
        </form>
    <?php elseif($step===2):?>
        <h3 style="margin-bottom:10px;font-size:18px">Import Tables</h3>
        <p style="color:#666;font-size:13px;margin-bottom:20px">The following SQL files will be imported to <b><?php echo htmlspecialchars($db['name'])?></b>:</p>
        
        <div class="sql-list">
            <?php foreach($sqlFiles as $f): if(file_exists(__DIR__.'/'.$f)): ?>
                <div class="sql-item"><?php echo $f ?></div>
            <?php endif; endforeach; ?>
        </div>

        <form method="POST">
            <input type="hidden" name="db_host" value="<?php echo htmlspecialchars($db['host'])?>">
            <input type="hidden" name="db_name" value="<?php echo htmlspecialchars($db['name'])?>">
            <input type="hidden" name="db_user" value="<?php echo htmlspecialchars($db['user'])?>">
            <input type="hidden" name="db_pass" value="<?php echo htmlspecialchars($db['pass'])?>">
            <button type="submit" name="import_sql" class="btn">Start Full Installation</button>
        </form>
    <?php elseif($step===3):?>
        <div class="done-card">
            <h2>SUCCESS!</h2>
            <p style="color:#888">Your website has been successfully installed.</p>
            
            <a href="/admin/" class="admin-link">
                <b>GO TO ADMIN PANEL</b>
                <span>Click here to manage your website content</span>
            </a>

            <div style="background:#0a0a0a;padding:15px;border-radius:10px;text-align:left;font-size:13px;margin-bottom:25px;border:1px solid #1a1a1a">
                <p style="margin-bottom:10px;color:#39ff14;font-weight:bold">Default Credentials:</p>
                <p>Email: <code style="color:#fff">admin@example.com</code></p>
                <p>Pass: <code style="color:#fff">Admin@12345</code></p>
            </div>

            <a href="/" class="btn" style="background:#111;color:#39ff14;border:1px solid #39ff14">VISIT HOME PAGE</a>
        </div>
    <?php endif?>

    <?php if(!empty($logs)): ?>
        <div class="log-box">
            <?php foreach($logs as $log): ?>
                <div class="log-entry"><?php echo htmlspecialchars($log) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
