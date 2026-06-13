<?php
/**
 * Admin Panel - Homepage V3 Content Manager
 */

require_once __DIR__ . '/includes/auth-v2.php';
requireAdmin();

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/csrf.php';

$pageTitle = 'Homepage V3 Content';
$message = '';
$error = '';

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token';
    } else {
        $action = $_POST['action'] ?? '';
        
        switch ($action) {
            case 'update_hero':
                $stmt = $pdo->prepare("UPDATE homepage_hero SET 
                    label_text = ?, main_heading = ?, subheading = ?, 
                    primary_btn_text = ?, primary_btn_link = ?, 
                    secondary_btn_text = ?, secondary_btn_link = ?,
                    hero_image = ?, background_image = ?, status = ?
                    WHERE id = 1");
                $stmt->execute([
                    $_POST['label_text'], $_POST['main_heading'], $_POST['subheading'],
                    $_POST['primary_btn_text'], $_POST['primary_btn_link'],
                    $_POST['secondary_btn_text'], $_POST['secondary_btn_link'],
                    $_POST['hero_image'], $_POST['background_image'],
                    isset($_POST['status']) ? 1 : 0
                ]);
                $message = 'Hero section updated successfully';
                break;
                
            case 'update_topbar':
                $stmt = $pdo->prepare("UPDATE homepage_topbar SET 
                    phone = ?, email = ?, address = ?, 
                    show_socials = ?, show_cart = ?, status = ?
                    WHERE id = 1");
                $stmt->execute([
                    $_POST['phone'], $_POST['email'], $_POST['address'],
                    isset($_POST['show_socials']) ? 1 : 0,
                    isset($_POST['show_cart']) ? 1 : 0,
                    isset($_POST['status']) ? 1 : 0
                ]);
                $message = 'Top bar updated successfully';
                break;
                
            case 'add_trust_badge':
                $stmt = $pdo->prepare("INSERT INTO homepage_trust_badges (icon, text, sort_order, status) VALUES (?, ?, ?, 1)");
                $stmt->execute([$_POST['icon'], $_POST['text'], $_POST['sort_order']]);
                $message = 'Trust badge added successfully';
                break;
                
            case 'update_trust_badge':
                $stmt = $pdo->prepare("UPDATE homepage_trust_badges SET icon = ?, text = ?, sort_order = ?, status = ? WHERE id = ?");
                $stmt->execute([
                    $_POST['icon'], $_POST['text'], $_POST['sort_order'],
                    isset($_POST['status']) ? 1 : 0,
                    $_POST['id']
                ]);
                $message = 'Trust badge updated successfully';
                break;
                
            case 'delete_trust_badge':
                $stmt = $pdo->prepare("DELETE FROM homepage_trust_badges WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $message = 'Trust badge deleted successfully';
                break;
                
            case 'add_feature':
                $stmt = $pdo->prepare("INSERT INTO homepage_features (icon, title, subtitle, sort_order, status) VALUES (?, ?, ?, ?, 1)");
                $stmt->execute([$_POST['icon'], $_POST['title'], $_POST['subtitle'], $_POST['sort_order']]);
                $message = 'Feature added successfully';
                break;
                
            case 'update_feature':
                $stmt = $pdo->prepare("UPDATE homepage_features SET icon = ?, title = ?, subtitle = ?, sort_order = ?, status = ? WHERE id = ?");
                $stmt->execute([
                    $_POST['icon'], $_POST['title'], $_POST['subtitle'], $_POST['sort_order'],
                    isset($_POST['status']) ? 1 : 0,
                    $_POST['id']
                ]);
                $message = 'Feature updated successfully';
                break;
                
            case 'delete_feature':
                $stmt = $pdo->prepare("DELETE FROM homepage_features WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $message = 'Feature deleted successfully';
                break;
                
            case 'add_category':
                $stmt = $pdo->prepare("INSERT INTO homepage_categories (title, subtitle, image, link, sort_order, status) VALUES (?, ?, ?, ?, ?, 1)");
                $stmt->execute([$_POST['title'], $_POST['subtitle'], $_POST['image'], $_POST['link'], $_POST['sort_order']]);
                $message = 'Category added successfully';
                break;
                
            case 'update_category':
                $stmt = $pdo->prepare("UPDATE homepage_categories SET title = ?, subtitle = ?, image = ?, link = ?, sort_order = ?, status = ? WHERE id = ?");
                $stmt->execute([
                    $_POST['title'], $_POST['subtitle'], $_POST['image'], $_POST['link'], $_POST['sort_order'],
                    isset($_POST['status']) ? 1 : 0,
                    $_POST['id']
                ]);
                $message = 'Category updated successfully';
                break;
                
            case 'delete_category':
                $stmt = $pdo->prepare("DELETE FROM homepage_categories WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $message = 'Category deleted successfully';
                break;
                
            case 'add_stat':
                $stmt = $pdo->prepare("INSERT INTO homepage_stats (icon, number, label, sort_order, status) VALUES (?, ?, ?, ?, 1)");
                $stmt->execute([$_POST['icon'], $_POST['number'], $_POST['label'], $_POST['sort_order']]);
                $message = 'Stat added successfully';
                break;
                
            case 'update_stat':
                $stmt = $pdo->prepare("UPDATE homepage_stats SET icon = ?, number = ?, label = ?, sort_order = ?, status = ? WHERE id = ?");
                $stmt->execute([
                    $_POST['icon'], $_POST['number'], $_POST['label'], $_POST['sort_order'],
                    isset($_POST['status']) ? 1 : 0,
                    $_POST['id']
                ]);
                $message = 'Stat updated successfully';
                break;
                
            case 'delete_stat':
                $stmt = $pdo->prepare("DELETE FROM homepage_stats WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $message = 'Stat deleted successfully';
                break;
        }
    }
}

// Fetch Data
$hero = dbFetchOne("SELECT * FROM homepage_hero WHERE id = 1") ?: [];
$topbar = dbFetchOne("SELECT * FROM homepage_topbar WHERE id = 1") ?: [];
$trustBadges = dbFetchAll("SELECT * FROM homepage_trust_badges ORDER BY sort_order");
$features = dbFetchAll("SELECT * FROM homepage_features ORDER BY sort_order");
$categories = dbFetchAll("SELECT * FROM homepage_categories ORDER BY sort_order");
$stats = dbFetchAll("SELECT * FROM homepage_stats ORDER BY sort_order");

include __DIR__ . '/includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Homepage V3 Content Manager</h4>
                    <p class="text-muted mb-0">Manage dark neon green streetwear homepage content</p>
                </div>
                <div class="card-body">
                    <?php if ($message): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo e($message); ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo e($error); ?>
                    </div>
                    <?php endif; ?>

                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs mb-4" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#hero">Hero Section</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#topbar">Top Bar</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#trust">Trust Badges</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#features">Features</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#categories">Categories</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#stats">Stats</a></li>
                    </ul>

                    <div class="tab-content">
                        <!-- Hero Section Tab -->
                        <div id="hero" class="tab-pane fade show active">
                            <form method="POST" class="needs-validation" novalidate>
                                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                                <input type="hidden" name="action" value="update_hero">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Label Text</label>
                                            <input type="text" name="label_text" class="form-control" value="<?php echo e($hero['label_text'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Main Heading</label>
                                            <input type="text" name="main_heading" class="form-control" value="<?php echo e($hero['main_heading'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Subheading</label>
                                    <textarea name="subheading" class="form-control" rows="3" required><?php echo e($hero['subheading'] ?? ''); ?></textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Primary Button Text</label>
                                            <input type="text" name="primary_btn_text" class="form-control" value="<?php echo e($hero['primary_btn_text'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Primary Button Link</label>
                                            <input type="text" name="primary_btn_link" class="form-control" value="<?php echo e($hero['primary_btn_link'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Secondary Button Text</label>
                                            <input type="text" name="secondary_btn_text" class="form-control" value="<?php echo e($hero['secondary_btn_text'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Secondary Button Link</label>
                                            <input type="text" name="secondary_btn_link" class="form-control" value="<?php echo e($hero['secondary_btn_link'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Hero Image URL</label>
                                            <input type="text" name="hero_image" class="form-control" value="<?php echo e($hero['hero_image'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Background Image URL</label>
                                            <input type="text" name="background_image" class="form-control" value="<?php echo e($hero['background_image'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="heroStatus" name="status" <?php echo ($hero['status'] ?? 1) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="heroStatus">Active</label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Update Hero Section</button>
                            </form>
                        </div>

                        <!-- Top Bar Tab -->
                        <div id="topbar" class="tab-pane fade">
                            <form method="POST" class="needs-validation" novalidate>
                                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                                <input type="hidden" name="action" value="update_topbar">
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control" value="<?php echo e($topbar['phone'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" value="<?php echo e($topbar['email'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control" value="<?php echo e($topbar['address'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox d-inline-block mr-3">
                                        <input type="checkbox" class="custom-control-input" id="showSocials" name="show_socials" <?php echo ($topbar['show_socials'] ?? 1) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="showSocials">Show Social Icons</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block mr-3">
                                        <input type="checkbox" class="custom-control-input" id="showCart" name="show_cart" <?php echo ($topbar['show_cart'] ?? 0) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="showCart">Show Cart Icon</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block">
                                        <input type="checkbox" class="custom-control-input" id="topbarStatus" name="status" <?php echo ($topbar['status'] ?? 1) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="topbarStatus">Active</label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Update Top Bar</button>
                            </form>
                        </div>

                        <!-- Trust Badges Tab -->
                        <div id="trust" class="tab-pane fade">
                            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addTrustModal">Add Trust Badge</button>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Icon</th>
                                        <th>Text</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($trustBadges as $badge): ?>
                                    <tr>
                                        <td><?php echo e($badge['icon']); ?></td>
                                        <td><?php echo e($badge['text']); ?></td>
                                        <td><?php echo e($badge['sort_order']); ?></td>
                                        <td><?php echo $badge['status'] ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>'; ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="editTrustBadge(<?php echo htmlspecialchars(json_encode($badge)); ?>)">Edit</button>
                                            <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this badge?');">
                                                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                                                <input type="hidden" name="action" value="delete_trust_badge">
                                                <input type="hidden" name="id" value="<?php echo $badge['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Features Tab -->
                        <div id="features" class="tab-pane fade">
                            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addFeatureModal">Add Feature</button>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Icon</th>
                                        <th>Title</th>
                                        <th>Subtitle</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($features as $feature): ?>
                                    <tr>
                                        <td><?php echo e($feature['icon']); ?></td>
                                        <td><?php echo e($feature['title']); ?></td>
                                        <td><?php echo e($feature['subtitle']); ?></td>
                                        <td><?php echo e($feature['sort_order']); ?></td>
                                        <td><?php echo $feature['status'] ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>'; ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="editFeature(<?php echo htmlspecialchars(json_encode($feature)); ?>)">Edit</button>
                                            <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this feature?');">
                                                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                                                <input type="hidden" name="action" value="delete_feature">
                                                <input type="hidden" name="id" value="<?php echo $feature['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Categories Tab -->
                        <div id="categories" class="tab-pane fade">
                            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addCategoryModal">Add Category</button>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Subtitle</th>
                                        <th>Image</th>
                                        <th>Link</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td><?php echo e($category['title']); ?></td>
                                        <td><?php echo e($category['subtitle']); ?></td>
                                        <td><img src="<?php echo e($category['image']); ?>" style="max-width:50px;" alt=""></td>
                                        <td><?php echo e($category['link']); ?></td>
                                        <td><?php echo e($category['sort_order']); ?></td>
                                        <td><?php echo $category['status'] ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>'; ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="editCategory(<?php echo htmlspecialchars(json_encode($category)); ?>)">Edit</button>
                                            <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this category?');">
                                                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                                                <input type="hidden" name="action" value="delete_category">
                                                <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Stats Tab -->
                        <div id="stats" class="tab-pane fade">
                            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addStatModal">Add Stat</button>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Icon</th>
                                        <th>Number</th>
                                        <th>Label</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stats as $stat): ?>
                                    <tr>
                                        <td><?php echo e($stat['icon']); ?></td>
                                        <td><?php echo e($stat['number']); ?></td>
                                        <td><?php echo e($stat['label']); ?></td>
                                        <td><?php echo e($stat['sort_order']); ?></td>
                                        <td><?php echo $stat['status'] ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>'; ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="editStat(<?php echo htmlspecialchars(json_encode($stat)); ?>)">Edit</button>
                                            <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this stat?');">
                                                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                                                <input type="hidden" name="action" value="delete_stat">
                                                <input type="hidden" name="id" value="<?php echo $stat['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals for Add/Edit forms would go here -->
<script>
function editTrustBadge(badge) { alert('Edit functionality - implement modal'); }
function editFeature(feature) { alert('Edit functionality - implement modal'); }
function editCategory(category) { alert('Edit functionality - implement modal'); }
function editStat(stat) { alert('Edit functionality - implement modal'); }
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
