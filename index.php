<?php

/**
 * Custom Streetwear v2 - Main Router
 * Enhanced with SEO v2, redirects, and new routes
 */

// Output compression
if (extension_loaded('zlib') && !headers_sent() && ob_get_level() === 0) {
    $enc = $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '';
    if (strpos($enc, 'gzip') !== false) {
        ob_start('ob_gzhandler');
    }
}

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/csrf.php';
require_once __DIR__ . '/includes/seo.php';
require_once __DIR__ . '/includes/seo-v2.php';

// Prevent browser/LiteSpeed caching of dynamic pages
if (!headers_sent()) {
    header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: 0');
}

// Check redirects first
checkRedirect();

// Direct import handler (bypasses cache)
if (isset($_GET['runimport']) && $_GET['runimport'] === 'custitty2024') {
    header('Content-Type: text/plain');
    try {
        $dsn = "mysql:host=" . DB_HOST . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE `" . DB_NAME . "`");
        $pdo->exec("SET NAMES utf8mb4");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $sql = file_get_contents(__DIR__ . '/master.sql');
        if (!$sql) die("master.sql not found");
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

        // Fix phone number
        $pdo->exec("UPDATE site_settings SET setting_value = '03279903608' WHERE setting_key = 'site_phone'");
        $pdo->exec("UPDATE site_settings SET setting_value = '03279903608' WHERE setting_key = 'whatsapp_button_number'");
        $pdo->exec("UPDATE homepage_topbar SET phone = '03279903608' WHERE id = 1");

        // Fix hero image
        $pdo->exec("UPDATE homepage_hero SET hero_image = '/uploads/hero-image.webp' WHERE id = 1");

        // Fix logo path to WebP
        $pdo->exec("UPDATE site_settings SET setting_value = '/uploads/settings/logo.webp' WHERE setting_key = 'site_logo_image' AND setting_value LIKE '%.png'");

        // Fix all image paths to WebP
        $pdo->exec("UPDATE homepage_categories SET image = REPLACE(image, '.jpg', '.webp') WHERE image LIKE '%.jpg'");
        $pdo->exec("UPDATE homepage_categories SET image = REPLACE(image, '.png', '.webp') WHERE image LIKE '%.png'");
        $pdo->exec("UPDATE homepage_hero SET hero_image = REPLACE(hero_image, '.jpg', '.webp') WHERE hero_image LIKE '%.jpg'");

        // Fix admin credentials
        $hash = password_hash('Wafa@1122', PASSWORD_DEFAULT);
        $pdo->exec("UPDATE admins SET email = 'info@customstreetwear.co', password_hash = '{$hash}' WHERE email = 'admin@example.com'");

        // Fix schema telephone
        // (handled in template)

        file_put_contents(__DIR__ . '/.installed', date('Y-m-d H:i:s'));
        echo "SUCCESS - {$count} queries executed + phone & hero fixed";
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage();
    }
    exit;
}

// Handle special endpoints
$route = isset($_GET['route']) ? trim($_GET['route'], '/') : '';

// Serve uploads files directly (LiteSpeed stat cache workaround)
if (preg_match('/^uploads\/.+/', $route)) {
    $file = __DIR__ . '/' . $route;
    if (file_exists($file)) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mime = ['jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','gif'=>'image/gif','webp'=>'image/webp','svg'=>'image/svg+xml','ico'=>'image/x-icon'];
        while (ob_get_level()) ob_end_clean();
        header('Content-Type: ' . ($mime[$ext] ?? 'application/octet-stream'));
        header('Cache-Control: public, max-age=31536000, immutable');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
        readfile($file);
        exit;
    }
}

// Sitemap XML
if ($route === 'sitemap.xml.php' || basename($_SERVER['PHP_SELF'] ?? '') === 'sitemap.xml.php') {
    if (getSetting('seo_enable_sitemap', '1') === '1') {
        generateSitemap();
    }
}

// Robots.txt
if ($route === 'robots.txt' || basename($_SERVER['PHP_SELF'] ?? '') === 'robots.txt') {
    if (getSetting('seo_enable_robots', '1') === '1') {
        generateRobots();
    }
}

$segments = explode('/', $route);
$page = $segments[0] ?? '';

if (empty($page)) {
    $page = 'home';
}

$template = null;
$params = [];

switch ($page) {
    case 'home':
        $template = 'home-v3.php';
        break;
        
    case 'about-us':
        $template = 'about-v2.php';
        break;
        
    case 'what-we-do':
        $template = 'what-we-do-v2.php';
        break;
        
    case 'how-we-do':
        $template = 'how-we-do-v2.php';
        break;
        
    case 'color-charts':
        $template = 'page.php';
        $params['slug'] = 'color-charts';
        break;
        
    case 'brochures':
        $template = 'page.php';
        $params['slug'] = 'brochures';
        break;
        
    case 'category':
        if (isset($segments[1])) {
            if ($segments[1] === 'all') {
                $template = 'categories-all-v2.php';
            } else {
                $params['slug'] = $segments[1];
                $template = 'category-v2.php';
            }
        }
        break;
        
    case 'product':
        if (isset($segments[1])) {
            $params['slug'] = $segments[1];
            $template = 'product-detail-v2.php';
        }
        break;
        
    case 'customisations':
        $template = 'customisations-v2.php';
        break;

    case 'customisation':
        $template = 'customisations-v2.php';
        break;
        
    case 'fabrics':
        $template = 'fabrics-v2.php';
        break;

    case 'fabric':
        $template = 'fabrics-v2.php';
        break;
        
    case 'blogs':
        $template = 'blog-list-v2.php';
        if (isset($segments[1])) {
            $params['slug'] = $segments[1];
            $template = 'blog-detail-v2.php';
        }
        break;
        
    case 'blog':
        if (isset($segments[1])) {
            $params['slug'] = $segments[1];
            $template = 'blog-detail-v2.php';
        }
        break;
        
    case 'contact':
        $template = 'contact-v2.php';
        break;
        
    case 'sports-uniforms':
        $template = 'sports-uniforms-v2.php';
        break;
        
    case 'locations':
        if (isset($segments[2])) {
            $params['state_slug'] = $segments[1];
            $params['city_slug'] = $segments[2];
            $template = 'location-city-v2.php';
        } elseif (isset($segments[1])) {
            $params['state_slug'] = $segments[1];
            $template = 'location-state-v2.php';
        } else {
            $template = 'locations-v2.php';
        }
        break;
        
    case 'market-area':
        $template = 'locations-v2.php';
        break;
        
    case 'faq':
        $template = 'faq-mega.php';
        break;
        
    case 'checkout':
        $template = 'checkout-v2.php';
        break;
        
    case 'privacy-policy':
        $template = 'page.php';
        $params['slug'] = 'privacy-policy';
        break;
        
    case 'return-policy':
        $template = 'page.php';
        $params['slug'] = 'return-policy';
        break;
        
    case 'terms':
        $template = 'page.php';
        $params['slug'] = 'terms';
        break;
        
    case 'sitemap':
        $template = 'sitemap-v2.php';
        break;
        
    default:
        $pageData = dbFetchOne("SELECT * FROM pages WHERE slug = ? AND status = 1", [$page]);
        if ($pageData) {
            $template = 'page.php';
            $params['slug'] = $page;
        } else {
            $template = '404-v2.php';
            http_response_code(404);
        }
}

if (!$template) {
    $template = '404-v2.php';
    http_response_code(404);
}

$templatePath = TEMPLATES_PATH . '/' . $template;
if (!file_exists($templatePath)) {
    $templatePath = TEMPLATES_PATH . '/404-v2.php';
    http_response_code(404);
}

extract($params);
include $templatePath;
