<?php
/**
 * Custom Streetwear - Product Detail Template
 */

require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/seo.php';

$slug = $slug ?? '';
$product = getProduct($slug);

if (!$product) {
    include __DIR__ . '/404.php';
    exit;
}

$images = getProductImages($product['id']);
$related = getRelatedProducts($product['id'], $product['category_id'], 4);

$schemaScript = '<script type="application/ld+json">' . productSchema($product) . '</script>';
$metaTags = generateMetaTags($product['seo_title'] ?: $product['title'], $product['seo_description'] ?: $product['short_description']);
$extraHead = $schemaScript;

$extraHead .= '<style>
.product-tabs-nav{display:flex;gap:4px;margin-bottom:24px;border-bottom:1px solid var(--border);padding-bottom:0}
.product-tab-btn{padding:12px 24px;font-size:0.85rem;font-weight:500;background:none;border:none;border-bottom:2px solid transparent;color:var(--text-secondary);cursor:pointer;transition:all 0.3s ease;font-family:inherit}
.product-tab-btn.active,.product-tab-btn:hover{color:var(--text-primary);border-bottom-color:var(--accent)}
.product-tab-panel{display:none}
.product-tab-panel.active{display:block}
.prod-desc-3d-wrap{padding:60px 0;background:var(--bg-secondary);border-top:1px solid var(--border)}
.prod-desc-3d-box{position:relative;max-width:1000px;margin:0 auto;padding:48px;background:linear-gradient(145deg,var(--bg-card) 0%,color-mix(in srgb,var(--bg-card) 90%,var(--bg-secondary)) 100%);border:1px solid var(--border);border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,0.4),0 4px 16px rgba(0,0,0,0.2),inset 0 1px 0 rgba(255,255,255,0.05);transform:perspective(1000px) rotateX(2deg) rotateY(-1deg);transition:transform 0.5s ease,box-shadow 0.5s ease}
.prod-desc-3d-box:hover{transform:perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(-4px);box-shadow:0 32px 80px rgba(0,0,0,0.5),0 8px 24px rgba(0,0,0,0.3),inset 0 1px 0 rgba(255,255,255,0.08)}
.prod-desc-3d-box h2{font-family:var(--font-heading);font-size:clamp(1.3rem,2.5vw,1.8rem);font-weight:700;color:var(--text-primary);margin:32px 0 16px;padding-bottom:12px;border-bottom:2px solid var(--border);line-height:1.3}
.prod-desc-3d-box h2:first-child{margin-top:0;font-size:clamp(1.5rem,3vw,2.2rem);background:linear-gradient(135deg,var(--text-primary) 0%,color-mix(in srgb,var(--text-primary) 70%,var(--accent)) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.prod-desc-3d-box p{font-size:clamp(0.9rem,1.1vw,1rem);color:var(--text-secondary);line-height:1.8;margin-bottom:16px}
.prod-desc-3d-box strong{color:var(--text-primary);font-weight:600}
.prod-desc-3d-box ul,.prod-desc-3d-box ol{margin:16px 0;padding-left:24px}
.prod-desc-3d-box li{font-size:clamp(0.88rem,1vw,0.95rem);color:var(--text-secondary);line-height:1.7;margin-bottom:10px}
.prod-desc-3d-box ul li::before{content:"▸";position:absolute;left:0;top:0;color:var(--accent)}
.prod-desc-3d-box a{color:var(--accent);text-decoration:underline;text-underline-offset:3px;transition:opacity 0.3s}
.prod-desc-3d-box a:hover{opacity:0.7}
.prod-desc-3d-box::after{content:"";position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,transparent,var(--accent),transparent);border-radius:20px 20px 0 0;opacity:0.4}
</style>';

$breadcrumb = [
    ['label' => 'Products', 'url' => '/#categories'],
    ['label' => $product['category_name'], 'url' => '/category/' . $product['category_slug']],
    ['label' => $product['title']]
];

include __DIR__ . '/../includes/header.php';
?>

<section class="section" style="padding-top: 40px;">
    <div class="container">
        <?php echo buildBreadcrumb($breadcrumb); ?>
        
        <div class="product-detail-grid">
            <!-- Gallery -->
            <div class="product-gallery">
                <div class="product-gallery-main">
                    <img id="productMainImage" src="<?php echo e($product['main_image'] ?: '/uploads/products/' . $product['slug'] . '.jpg'); ?>" alt="<?php echo e($product['alt_text'] ?: $product['title']); ?>">
                </div>
                <?php if (!empty($images)): ?>
                <div class="product-gallery-thumbs">
                    <div class="gallery-thumb active" onclick="switchGalleryImage(this, '<?php echo e($product['main_image'] ?: '/uploads/products/' . $product['slug'] . '.jpg'); ?>')">
                        <img src="<?php echo e($product['main_image'] ?: '/uploads/products/' . $product['slug'] . '.jpg'); ?>" alt="<?php echo e($product['title']); ?>">
                    </div>
                    <?php foreach ($images as $img): ?>
                    <div class="gallery-thumb" onclick="switchGalleryImage(this, '<?php echo e($img['image']); ?>')">
                        <img src="<?php echo e($img['image']); ?>" alt="<?php echo e($img['alt_text'] ?: $product['title']); ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Info -->
            <div class="product-info-detail reveal">
                <span class="section-label" style="margin-bottom: 12px; display: inline-block;"><?php echo e($product['category_name']); ?></span>
                <h1><?php echo e($product['title']); ?></h1>
                <div class="product-sku-detail">SKU: <?php echo e($product['sku']); ?></div>
                
                <div class="product-short-desc">
                    <?php echo nl2br(e($product['short_description'])); ?>
                </div>
                
                <?php if ($product['specifications']): ?>
                <div class="product-specs-list">
                    <?php foreach (explode("\n", $product['specifications']) as $spec): ?>
                    <?php $parts = explode(':', $spec, 2); if (count($parts) == 2): ?>
                    <div class="product-spec-item">
                        <span class="product-spec-label"><?php echo e(trim($parts[0])); ?>:</span>
                        <span class="product-spec-value"><?php echo e(trim($parts[1])); ?></span>
                    </div>
                    <?php endif; endforeach; ?>
                </div>
                <?php endif; ?>
                
                <?php if ($product['sizes']): ?>
                <div style="margin-bottom: 20px;">
                    <span class="form-label">Available Sizes</span>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <?php foreach (explode(',', $product['sizes']) as $size): ?>
                        <span style="padding: 6px 14px; background: var(--color-bg-alt); border: 1px solid var(--color-border); border-radius: var(--radius-sm); font-size: 13px;"><?php echo e(trim($size)); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($product['colors']): ?>
                <div style="margin-bottom: 30px;">
                    <span class="form-label">Available Colors</span>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <?php foreach (explode(',', $product['colors']) as $color): ?>
                        <span style="padding: 6px 14px; background: var(--color-bg-alt); border: 1px solid var(--color-border); border-radius: var(--radius-sm); font-size: 13px;"><?php echo e(trim($color)); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="product-actions-detail">
                    <button class="btn btn-primary btn-lg" onclick="openQuoteModal()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Request Quote
                    </button>
                    <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', getSetting('whatsapp_button_number', ''))); ?>?text=Hi, I am interested in <?php echo urlencode($product['title']); ?>" class="btn btn-outline btn-lg" target="_blank" rel="noopener">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Product Tabs -->
        <div class="product-tabs">
            <div class="product-tabs-nav">
                <button class="product-tab-btn active" data-tab="tab-description">Description</button>
                <?php if ($product['features']): ?>
                <button class="product-tab-btn" data-tab="tab-features">Features</button>
                <?php endif; ?>
                <?php if ($product['customization_options']): ?>
                <button class="product-tab-btn" data-tab="tab-customization">Customization</button>
                <?php endif; ?>
            </div>
            
            <div class="product-tab-panel active" id="tab-description">
                <div class="page-content">
                    <?php echo $product['full_description'] ? htmlspecialchars_decode($product['full_description'], ENT_QUOTES) : '<p>' . e($product['short_description']) . '</p>'; ?>
                </div>
            </div>
            
            <?php if ($product['features']): ?>
            <div class="product-tab-panel" id="tab-features">
                <div class="page-content">
                    <ul>
                        <?php foreach (explode(',', $product['features']) as $feature): ?>
                        <li><?php echo e(trim($feature)); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if ($product['customization_options']): ?>
            <div class="product-tab-panel" id="tab-customization">
                <div class="page-content">
                    <p><?php echo nl2br(e($product['customization_options'])); ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- 3D Description Box -->
<?php if (!empty($product['full_description'])): ?>
<section class="prod-desc-3d-wrap">
    <div class="container">
        <div class="prod-desc-3d-box">
            <?php echo htmlspecialchars_decode($product['full_description'], ENT_QUOTES); ?>
        </div>
        <div style="text-align:center;margin-top:40px;">
            <button class="btn-3d" onclick="openQuoteModal()">Get a Quote</button>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Related Products -->
<?php if (!empty($related)): ?>
<section class="section" style="background: var(--color-bg-alt);">
    <div class="container">
        <h2 class="section-title" style="font-size: 28px; margin-bottom: 40px;">Related Products</h2>
        <div class="product-grid">
            <?php foreach ($related as $r): ?>
            <div class="product-card">
                <div class="product-card-image">
                    <img src="<?php echo e($r['main_image'] ?: '/uploads/products/' . $r['slug'] . '.jpg'); ?>" alt="<?php echo e($r['title']); ?>" loading="lazy">
                    <div class="product-card-overlay">
                        <a href="/product/<?php echo e($r['slug']); ?>" class="product-card-action" title="View Details">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                        <button class="product-card-action" title="Request Quote" onclick="openQuoteModal()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        </button>
                    </div>
                </div>
                <div class="product-card-info">
                    <span class="product-card-category"><?php echo e($r['category_name']); ?></span>
                    <h3 class="product-card-title"><?php echo e($r['title']); ?></h3>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
function switchGalleryImage(thumb, src) {
    document.getElementById('productMainImage').src = src;
    document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
}
document.querySelectorAll('.product-tab-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var tab = this.getAttribute('data-tab');
        document.querySelectorAll('.product-tab-btn').forEach(function(b) { b.classList.remove('active'); });
        document.querySelectorAll('.product-tab-panel').forEach(function(p) { p.classList.remove('active'); });
        this.classList.add('active');
        var panel = document.getElementById(tab);
        if (panel) panel.classList.add('active');
    });
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
