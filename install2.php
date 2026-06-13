<?php
if (file_exists(__DIR__ . '/.installed') && !isset($_GET['force'])) {
    die('Website is already installed. Add ?force to URL to reinstall.');
}

$success = '';
$error = '';
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

$db = [
    'host' => 'localhost',
    'name' => 'custitty_wafa',
    'user' => 'custitty_wafa',
    'pass' => 'Wafa@4052364',
];

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
            $success = 'Connection OK! Click below to import.';
            $step = 2;
        } catch (PDOException $e) {
            $error = 'Failed: ' . $e->getMessage();
        }
    }

    if (isset($_POST['import_sql'])) {
        try {
            $dsn = "mysql:host={$db['host']};charset=utf8mb4";
            $pdo = new PDO($dsn, $db['user'], $db['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$db['name']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `{$db['name']}`");
            $pdo->exec("SET NAMES utf8mb4");
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

            $sql = file_get_contents(__DIR__ . '/master.sql');
            $sql = str_replace("\r\n", "\n", $sql);
            $lines = explode("\n", $sql);
            $stmt = '';
            $count = 0;

            foreach ($lines as $line) {
                $t = trim($line);
                if ($t === '' || substr($t, 0, 2) === '--') continue;
                $stmt .= $line . "\n";
                if (substr($t, -1) === ';') {
                    $q = trim($stmt, " \n\r\t;");
                    if (!empty($q)) {
                        try { $pdo->exec($q); $count++; } catch (PDOException $e) {}
                    }
                    $stmt = '';
                }
            }
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

            $cfg = __DIR__ . '/config/config.php';
            if (file_exists($cfg)) {
                $c = file_get_contents($cfg);
                $c = str_replace("'custitty_wafa');", "'{$db['name']}');", $c);
                $c = str_replace("'Wafa@4052364');", "'{$db['pass']}');", $c);
                file_put_contents($cfg, $c);
            }
            file_put_contents(__DIR__ . '/.installed', date('Y-m-d H:i:s'));
            $success = "Done! {$count} queries executed.";
            $step = 3;
        } catch (Exception $e) {
            $error = $e->getMessage();
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
<title>Installer</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:sans-serif;background:#0a0a0a;color:#fff;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.box{background:#111;border:1px solid #333;border-radius:12px;padding:40px;max-width:500px;width:100%}
h1{text-align:center;color:#39ff14;font-size:24px;margin-bottom:5px}
.sub{text-align:center;color:#888;font-size:14px;margin-bottom:30px}
.steps{display:flex;justify-content:center;gap:10px;margin-bottom:30px}
.s{width:40px;height:40px;border-radius:50%;background:#1a1a1a;color:#666;display:flex;align-items:center;justify-content:center;font-weight:600}
.s.a{background:#39ff14;color:#000}
.s.d{background:#1a3a1a;color:#39ff14}
label{display:block;font-size:13px;color:#888;margin-bottom:6px}
input{width:100%;padding:12px;background:#0a0a0a;border:1px solid #2a2a2a;border-radius:8px;color:#fff;font-size:14px;margin-bottom:20px}
input:focus{outline:none;border-color:#39ff14}
.btn{width:100%;padding:14px;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;background:#39ff14;color:#000}
.ok{background:#0a2f0a;border:1px solid #39ff14;color:#39ff14;padding:12px;border-radius:8px;margin-bottom:20px;font-size:13px}
.err{background:#2f0a0a;border:1px solid #ff3914;color:#ff3914;padding:12px;border-radius:8px;margin-bottom:20px;font-size:13px}
.info{background:#0a0a2f;border:1px solid #3939ff;color:#8888ff;padding:16px;border-radius:8px;margin-bottom:20px;font-size:13px;line-height:1.6}
.info b{color:#fff}
.done{text-align:center}
.done h2{color:#39ff14;margin:20px 0 15px}
.cred{background:#0a0a0a;border:1px solid #2a2a2a;border-radius:8px;padding:16px;margin:20px 0;font-size:13px;text-align:left}
.cred p{margin:5px 0}
.cred code{color:#39ff14}
</style>
</head>
<body>
<div class="box">
<h1>CUSTOM STREETWEAR</h1>
<p class="sub">Web Installer</p>
<div class="steps">
<div class="s <?php echo $step>=1?($step>1?'d':'a'):''; ?>">1</div>
<div class="s <?php echo $step>=2?($step>2?'d':'a'):''; ?>">2</div>
<div class="s <?php echo $step>=3?'d':''; ?>">3</div>
</div>
<?php if($success):?><div class="ok"><?php echo $success?></div><?php endif?>
<?php if($error):?><div class="err"><?php echo $error?></div><?php endif?>
<?php if($step===1):?>
<h3 style="margin-bottom:20px">Database Config</h3>
<div class="info"><b>Defaults:</b> Host: localhost | DB: custitty_wafa | User: custitty_wafa | Pass: Wafa@4052364</div>
<form method="POST">
<input type="text" name="db_host" value="<?php echo $db['host']?>" placeholder="Host" required>
<input type="text" name="db_name" value="<?php echo $db['name']?>" placeholder="Database" required>
<input type="text" name="db_user" value="<?php echo $db['user']?>" placeholder="User" required>
<input type="password" name="db_pass" value="<?php echo $db['pass']?>" placeholder="Password" required>
<button type="submit" name="test_connection" class="btn">Test Connection</button>
</form>
<?php elseif($step===2):?>
<h3 style="margin-bottom:20px">Import Database</h3>
<p style="color:#888;font-size:14px;margin-bottom:20px">Connection OK. Click to import.</p>
<form method="POST">
<input type="hidden" name="db_host" value="<?php echo htmlspecialchars($db['host'])?>">
<input type="hidden" name="db_name" value="<?php echo htmlspecialchars($db['name'])?>">
<input type="hidden" name="db_user" value="<?php echo htmlspecialchars($db['user'])?>">
<input type="hidden" name="db_pass" value="<?php echo htmlspecialchars($db['pass'])?>">
<button type="submit" name="import_sql" class="btn">Import Now</button>
</form>
<?php elseif($step===3):?>
<div class="done">
<h2>Done!</h2>
<div class="cred">
<p><b>Admin:</b> <a href="/admin/" style="color:#39ff14">/admin/</a></p>
<p>Email: <code>admin@example.com</code></p>
<p>Pass: <code>Admin@12345</code></p>
</div>
<p><a href="/" style="display:inline-block;padding:12px 24px;background:#39ff14;color:#000;border-radius:8px;text-decoration:none;font-weight:600">Visit Website</a></p>
</div>
<?php endif?>
</div>
</body>
</html>
