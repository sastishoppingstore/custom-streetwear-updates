<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/seo-v2.php';

$allCategories = getCategories();

$metaTags = generateAdvancedMetaTags([
    'meta_title' => getSetting('category_all_title', 'All Categories - Custom Apparel Manufacturer USA | Custom Streetwear'),
    'meta_description' => getSetting('category_all_desc', 'Browse all custom apparel categories including hoodies, tracksuits, jackets, t-shirts, uniforms and more. Factory-direct pricing, USA shipping.'),
    'focus_keyword' => 'Custom Apparel Categories',
]);

$extraHead = '';
include __DIR__ . '/../includes/header.php';
?>

<section style="padding:80px 0 40px;background:linear-gradient(135deg,var(--color-bg-alt) 0%,var(--color-bg) 100%);border-bottom:1px solid var(--color-border);">
    <div class="container">
        <?php echo advancedBreadcrumb([['label' => 'All Categories']]); ?>
        <div class="reveal">
            <span class="section-label"><?php echo e(getSetting('category_all_page_label', 'Product Categories')); ?></span>
            <h1 style="font-size:clamp(28px,4vw,48px);font-weight:800;margin:8px 0 16px;">All Categories - Custom Apparel Manufacturer USA</h1>
            <p style="color:var(--color-text-muted);max-width:600px;line-height:1.7;">Browse our complete range of custom apparel and streetwear categories.</p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="categories-grid stagger-children" data-animate>
            <?php if (empty($allCategories)): ?>
            <div style="grid-column:1/-1;text-align:center;padding:60px 0;color:var(--color-text-muted);">
                <p>No categories available yet.</p>
            </div>
            <?php endif; ?>
            <?php $coverBase = SITE_URL . '/uploads/categories/'; ?>
            <?php foreach ($allCategories as $cat): ?>
            <?php $coverImg = $cat['image'] ?: $coverBase . $cat['slug'] . '.webp'; ?>
            <a href="/category/<?php echo e($cat['slug']); ?>" class="category-card">
                <div class="category-card-image">
                    <img src="<?php echo e($coverImg); ?>" alt="<?php echo e($cat['name']); ?>" loading="lazy" onerror="this.style.display='none'">
                </div>
                <div class="category-card-body">
                    <span class="tag-pill">Category</span>
                    <h4 class="category-card-title"><?php echo e($cat['name']); ?></h4>
                    <?php if (!empty($cat['description'])): ?>
                    <p class="category-card-desc"><?php echo e($cat['description']); ?></p>
                    <?php endif; ?>
                    <span class="category-card-link">Explore &rarr;</span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
