<?php
/**
 * Custom Streetwear - Database Connection
 * PDO MySQL with prepared statements
 */

require_once __DIR__ . '/../config/config.php';

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $initCommand = 1002;
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        $initCommand => "SET NAMES " . DB_CHARSET . " COLLATE utf8mb4_unicode_ci"
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    if (getenv('CSW_DB_FALLBACK') === '1') {
        $pdo = null;
    } else {
        die("Database connection failed. Please try again later.");
    }
}

function dbFallbackEnabled() {
    global $pdo;
    return $pdo === null && getenv('CSW_DB_FALLBACK') === '1';
}

function dbFallbackData() {
    static $data = null;
    if ($data !== null) return $data;

    $settings = [
        'site_name' => 'Custom Streetwear',
        'site_email' => 'info@customstreetwear.co',
        'site_phone' => '03279903608',
        'site_address' => 'USA Custom Apparel Manufacturer',
        'site_logo_text' => 'CUSTOM STREETWEAR',
        'site_logo_image' => '/uploads/settings/logo.webp',
        'favicon' => '/uploads/settings/favicon.ico',
        'site_favicon' => '/uploads/settings/favicon.ico',
        'site_favicon_192' => '/uploads/settings/favicon.ico',
        'site_favicon_512' => '/uploads/settings/favicon.ico',
        'site_apple_touch_icon' => '/uploads/settings/favicon.ico',
        'og_image' => '/uploads/settings/og-image.jpg',
        'home_meta_title' => 'Custom Apparel Manufacturer in USA | Custom Streetwear',
        'home_meta_desc' => 'Custom Streetwear is a USA-focused custom apparel manufacturer for sports uniforms, streetwear, workwear, promotional apparel, and private label clothing with factory-direct pricing.',
        'home_sports_uniforms_target' => 'Custom Sports Uniforms Manufacturer in USA',
        'home_sports_uniforms_desc' => 'Custom Sports Uniforms Manufacturer in USA for teams, schools, leagues, clubs, and brands. Factory-direct custom jerseys, kits, sublimation uniforms, embroidery, and bulk team apparel shipped nationwide.',
        'home_hero_3d_enabled' => '1',
        'home_trust_bar_enabled' => '1',
        'site_psycology_first_look' => '1',
        'site_social_proof_enabled' => '1',
        'home_urgent_badge_text' => 'Bulk Orders Welcome | Ships Within 15-20 Days',
        'home_stat_clients_number' => '2500',
        'home_featured_count' => '8',
        'home_bestseller_count' => '8',
        'home_blog_count' => '4',
        'home_video_count' => '3',
        'home_brochure_count' => '8',
        'home_testimonial_count' => '6',
        'theme_primary_color' => '#39ff14',
    ];

    $categoryRows = [
        [1, 'Hoodies', 'hoodies'],
        [2, 'Tracksuits', 'tracksuits'],
        [3, 'T-Shirts', 't-shirts'],
        [4, 'Varsity Jackets', 'varsity-jackets'],
        [5, 'Softshell Jacket', 'softshell-jacket'],
        [6, 'Sports Uniform', 'sports-uniform'],
        [7, 'Promotional Products', 'promotional-products'],
        [8, 'Workwear', 'workwear'],
        [9, 'Hospital Uniform', 'hospital-uniform'],
        [10, 'Bomber Jackets', 'bomber-jackets'],
        [11, 'Winter Coat', 'winter-coat'],
        [12, 'Leather Jackets', 'leather-jackets'],
        [13, 'Motorcycle Jackets', 'motorcycle-jackets'],
    ];
    $categories = [];
    foreach ($categoryRows as $row) {
        [$id, $name, $slug] = $row;
        $categories[] = [
            'id' => $id,
            'name' => $name,
            'slug' => $slug,
            'description' => 'Custom ' . strtolower($name) . ' manufacturing for USA brands, teams, companies, and organizations.',
            'image' => '/uploads/categories/' . $slug . '.jpg',
            'seo_title' => 'Custom ' . $name . ' Manufacturer USA',
            'seo_description' => 'Custom ' . strtolower($name) . ' manufacturer serving USA buyers with factory-direct pricing.',
            'status' => 1,
            'sort_order' => $id,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }

    $productRows = [
        [1, 'Custom Acid Washed Hoodie', 'custom-acid-washed-hoodie', 'CSW-HD-001', 1, 1],
        [1, 'Custom Tie Dye Hoodie', 'custom-tie-dye-hoodie', 'CSW-HD-002', 1, 0],
        [1, 'Custom Sublimation Hoodie', 'custom-sublimation-hoodie', 'CSW-HD-003', 1, 1],
        [1, 'Custom Sweatshirt', 'custom-sweatshirt', 'CSW-HD-004', 0, 0],
        [2, 'Custom Tracksuit Set', 'custom-tracksuit-set', 'CSW-TR-001', 1, 1],
        [3, 'Custom Sublimation T-Shirt', 'custom-sublimation-t-shirt', 'CSW-TS-001', 1, 1],
        [3, 'Custom Polo Shirt', 'custom-polo-shirt', 'CSW-TS-002', 0, 0],
        [4, 'Custom Varsity Jacket', 'custom-varsity-jacket', 'CSW-VJ-001', 1, 1],
        [5, 'Custom Softshell Jacket', 'custom-softshell-jacket', 'CSW-SJ-001', 1, 0],
        [6, 'American Football Uniform', 'american-football-uniform', 'CSW-SU-001', 1, 1],
        [6, 'Baseball Uniform', 'baseball-uniform', 'CSW-SU-002', 1, 0],
        [6, 'Basketball Uniform', 'basketball-uniform', 'CSW-SU-003', 1, 1],
        [6, 'Soccer Uniform Kit', 'soccer-uniform-kit', 'CSW-SU-004', 1, 1],
        [6, 'Rugby Uniform', 'rugby-uniform', 'CSW-SU-005', 0, 0],
        [6, 'Hockey Uniform', 'hockey-uniform', 'CSW-SU-006', 0, 0],
        [7, 'Promotional Hoodie', 'promotional-hoodie', 'CSW-PP-001', 0, 0],
        [7, 'Promotional T-Shirt', 'promotional-t-shirt', 'CSW-PP-002', 0, 0],
        [8, 'Mechanic Uniform', 'mechanic-uniform', 'CSW-WW-001', 0, 0],
        [8, 'Safety Coverall', 'safety-coverall', 'CSW-WW-002', 1, 0],
        [9, 'Medical Scrub Set', 'medical-scrub-set', 'CSW-HU-001', 1, 1],
        [12, 'Custom Leather Jacket', 'custom-leather-jacket', 'CSW-LJ-001', 1, 1],
        [13, 'Custom Motorcycle Jacket', 'custom-motorcycle-jacket', 'CSW-MJ-001', 1, 0],
    ];
    $categoryById = [];
    foreach ($categories as $cat) $categoryById[$cat['id']] = $cat;
    $products = [];
    foreach ($productRows as $i => $row) {
        [$categoryId, $title, $slug, $sku, $featured, $bestSeller] = $row;
        $cat = $categoryById[$categoryId] ?? ['name' => '', 'slug' => ''];
        $products[] = [
            'id' => $i + 1,
            'category_id' => $categoryId,
            'title' => $title,
            'slug' => $slug,
            'sku' => $sku,
            'short_description' => $title . ' manufactured for custom USA apparel buyers.',
            'full_description' => '<p>' . $title . ' manufactured with custom branding, sizing, and bulk production support.</p>',
            'main_image' => '/uploads/products/' . $slug . '.jpg',
            'alt_text' => $title,
            'category_name' => $cat['name'],
            'category_slug' => $cat['slug'],
            'is_featured' => $featured,
            'is_best_seller' => $bestSeller,
            'status' => 1,
            'sort_order' => $i + 1,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }

    $data = [
        'settings' => $settings,
        'categories' => $categories,
        'products' => $products,
        'sliders' => [
            ['title' => 'Custom Apparel Manufacturer in USA', 'subtitle' => 'Factory-Direct Custom Clothing', 'description' => 'Sports uniforms, streetwear, workwear, promotional apparel, and private label production for USA buyers.', 'image' => '/uploads/sliders/slider-1.jpg', 'button_text' => 'Request a Quote', 'button_link' => '/contact', 'status' => 1, 'sort_order' => 1],
            ['title' => 'Custom Sports Uniforms Manufacturer in USA', 'subtitle' => 'Teams, Schools & Leagues', 'description' => 'Custom jerseys, kits, uniforms, sublimation, embroidery, and bulk team apparel shipped nationwide.', 'image' => '/uploads/sliders/slider-2.jpg', 'button_text' => 'Explore Sports', 'button_link' => '/sports-uniforms', 'status' => 1, 'sort_order' => 2],
        ],
        'home_sections' => array_map(function ($key, $i) {
            return ['id' => $i + 1, 'section_key' => $key, 'section_name' => ucwords(str_replace('-', ' ', $key)), 'title' => '', 'subtitle' => '', 'description' => '', 'image' => '', 'image_alt' => '', 'background_color' => '', 'background_image' => '', 'custom_css' => '', 'custom_html' => '', 'visibility' => 'visible', 'sort_order' => $i + 1];
        }, ['hero','categories','bestsellers','about','whychoose','featured','tech','videos','testimonials','locations','blogs','cta'], array_keys(['hero','categories','bestsellers','about','whychoose','featured','tech','videos','testimonials','locations','blogs','cta'])),
        'testimonials' => [
            ['client_name' => 'USA Team Buyer', 'company' => 'Sports Club', 'country' => 'USA', 'message' => 'The uniforms looked sharp and arrived on schedule.', 'rating' => 5],
            ['client_name' => 'Brand Owner', 'company' => 'Streetwear Label', 'country' => 'USA', 'message' => 'Reliable production support and clean custom apparel results.', 'rating' => 5],
        ],
        'blogs' => [],
        'videos' => [],
        'brochures' => [],
        'menus' => [
            ['id' => 1, 'parent_id' => null, 'title' => 'Home', 'url' => '/', 'menu_location' => 'header', 'status' => 1, 'sort_order' => 1],
            ['id' => 2, 'parent_id' => null, 'title' => 'Categories', 'url' => '#', 'menu_location' => 'header', 'status' => 1, 'sort_order' => 2],
            ['id' => 3, 'parent_id' => null, 'title' => 'Sports Uniforms', 'url' => '/sports-uniforms', 'menu_location' => 'header', 'status' => 1, 'sort_order' => 3],
            ['id' => 4, 'parent_id' => null, 'title' => 'Locations', 'url' => '/locations', 'menu_location' => 'header', 'status' => 1, 'sort_order' => 4],
            ['id' => 5, 'parent_id' => null, 'title' => 'Contact', 'url' => '/contact', 'menu_location' => 'header', 'status' => 1, 'sort_order' => 5],
        ],
    ];
    foreach ($categories as $i => $cat) {
        $data['menus'][] = ['id' => 20 + $i, 'parent_id' => 2, 'title' => $cat['name'], 'url' => '/category/' . $cat['slug'], 'menu_location' => 'header', 'status' => 1, 'sort_order' => $i + 1];
    }
    return $data;
}

class DbFallbackStatement {
    private $rows;
    private $position = 0;

    public function __construct($rows = []) {
        $this->rows = array_values($rows);
    }

    public function fetch() {
        if (!isset($this->rows[$this->position])) return false;
        return $this->rows[$this->position++];
    }

    public function fetchAll() {
        return $this->rows;
    }

    public function fetchColumn($column = 0) {
        $row = $this->rows[0] ?? null;
        if (!$row) return false;
        if (is_int($column)) {
            $values = array_values($row);
            return $values[$column] ?? false;
        }
        return $row[$column] ?? false;
    }

    public function rowCount() {
        return 0;
    }
}

function dbFallbackLimit($sql, $rows) {
    if (preg_match('/\bLIMIT\s+(\d+)/i', $sql, $matches)) {
        return array_slice($rows, 0, (int)$matches[1]);
    }
    return $rows;
}

function dbFallbackRows($sql, $params = []) {
    $data = dbFallbackData();
    $lower = strtolower(preg_replace('/\s+/', ' ', trim($sql)));

    if (strpos($lower, 'from site_settings') !== false) {
        $rows = [];
        foreach ($data['settings'] as $key => $value) {
            $rows[] = ['setting_key' => $key, 'setting_value' => $value];
        }
        return $rows;
    }

    if (strpos($lower, 'from categories') !== false && strpos($lower, 'join') === false) {
        $rows = $data['categories'];
        if (strpos($lower, 'where slug = ?') !== false) {
            $slug = $params[0] ?? '';
            $rows = array_values(array_filter($rows, fn($row) => $row['slug'] === $slug));
        }
        if (strpos($lower, 'count(*)') !== false) return [['c' => count($rows), 'count(*)' => count($rows)]];
        return dbFallbackLimit($sql, $rows);
    }

    if (strpos($lower, 'from subcategories') !== false) {
        return [];
    }

    if (strpos($lower, 'from products p') !== false) {
        $rows = $data['products'];
        $paramIndex = 0;
        if (strpos($lower, 'p.id != ?') !== false) {
            $id = (int)($params[$paramIndex++] ?? 0);
            $rows = array_values(array_filter($rows, fn($row) => (int)$row['id'] !== $id));
        }
        if (strpos($lower, 'p.slug = ?') !== false) {
            $slug = $params[$paramIndex++] ?? '';
            $rows = array_values(array_filter($rows, fn($row) => $row['slug'] === $slug));
        }
        if (strpos($lower, 'p.category_id = ?') !== false) {
            $categoryId = (int)($params[$paramIndex++] ?? 0);
            $rows = array_values(array_filter($rows, fn($row) => (int)$row['category_id'] === $categoryId));
        }
        if (strpos($lower, 'p.is_featured = 1') !== false) {
            $rows = array_values(array_filter($rows, fn($row) => !empty($row['is_featured'])));
        }
        if (strpos($lower, 'p.is_best_seller = 1') !== false) {
            $rows = array_values(array_filter($rows, fn($row) => !empty($row['is_best_seller'])));
        }
        if (strpos($lower, 'count(*)') !== false) return [['c' => count($rows), 'count(*)' => count($rows)]];
        return dbFallbackLimit($sql, $rows);
    }

    if (strpos($lower, 'from products') !== false) {
        $rows = $data['products'];
        if (strpos($lower, 'where id = ?') !== false) {
            $id = (int)($params[0] ?? 0);
            $rows = array_values(array_filter($rows, fn($row) => (int)$row['id'] === $id));
        }
        if (strpos($lower, 'where slug = ?') !== false) {
            $slug = $params[0] ?? '';
            $rows = array_values(array_filter($rows, fn($row) => $row['slug'] === $slug));
        }
        if (strpos($lower, 'count(*)') !== false) return [['c' => count($rows), 'count(*)' => count($rows)]];
        return dbFallbackLimit($sql, $rows);
    }

    foreach (['sliders', 'testimonials', 'blogs', 'videos', 'brochures', 'home_sections'] as $table) {
        if (strpos($lower, 'from ' . $table) !== false) {
            $rows = $data[$table] ?? [];
            if (strpos($lower, 'count(*)') !== false) return [['c' => count($rows), 'count(*)' => count($rows)]];
            return dbFallbackLimit($sql, $rows);
        }
    }

    if (strpos($lower, 'from menus') !== false) {
        $rows = $data['menus'];
        if (strpos($lower, 'menu_location = ?') !== false) {
            $location = $params[0] ?? 'header';
            $rows = array_values(array_filter($rows, fn($row) => $row['menu_location'] === $location));
        }
        return $rows;
    }

    if (strpos($lower, 'from site_reviews') !== false) {
        if (strpos($lower, 'avg(rating)') !== false) return [['r' => 4.9]];
        if (strpos($lower, 'count(*)') !== false) return [['c' => 0]];
        return [];
    }

    if (strpos($lower, 'from product_images') !== false) {
        return [];
    }

    if (strpos($lower, 'from pages') !== false || strpos($lower, 'from redirects') !== false ||
        strpos($lower, 'from location_seo') !== false || strpos($lower, 'from faq_categories') !== false ||
        strpos($lower, 'from faqs') !== false || strpos($lower, 'from fabrics') !== false ||
        strpos($lower, 'from customisations') !== false || strpos($lower, 'from delivery_charges') !== false ||
        strpos($lower, 'from seo_meta') !== false) {
        if (strpos($lower, 'count(*)') !== false) return [['c' => 0, 'count(*)' => 0]];
        return [];
    }

    return [];
}

/**
 * Get PDO instance
 */
function getDB() {
    global $pdo;
    return $pdo;
}

/**
 * Execute a prepared query and return statement
 */
function dbQuery($sql, $params = []) {
    if (dbFallbackEnabled()) {
        return new DbFallbackStatement(dbFallbackRows($sql, $params));
    }
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

/**
 * Fetch single row
 */
function dbFetchOne($sql, $params = []) {
    return dbQuery($sql, $params)->fetch();
}

/**
 * Fetch all rows
 */
function dbFetchAll($sql, $params = []) {
    return dbQuery($sql, $params)->fetchAll();
}

/**
 * Insert and get last ID
 */
function dbInsert($sql, $params = []) {
    if (dbFallbackEnabled()) return 0;
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $db->lastInsertId();
}

/**
 * Update/Delete - return affected rows
 */
function dbExecute($sql, $params = []) {
    $stmt = dbQuery($sql, $params);
    return $stmt->rowCount();
}

/**
 * Count rows
 */
function dbCount($table, $where = '', $params = []) {
    $sql = "SELECT COUNT(*) FROM " . $table;
    if ($where) {
        $sql .= " WHERE " . $where;
    }
    return dbQuery($sql, $params)->fetchColumn();
}
