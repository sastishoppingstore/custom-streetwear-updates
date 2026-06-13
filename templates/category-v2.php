<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/seo-v2.php';

$slug = $slug ?? '';
$category = dbFetchOne("SELECT * FROM categories WHERE slug = ? AND status = 1", [$slug]);

if (!$category) {
    header('Location: /category/all');
    exit;
}

$subcategories = getSubcategories($category['id']);
$products = getProducts(['category_id' => $category['id']], 24);

$metaTags = generateAdvancedMetaTags([
    'meta_title' => ($category['seo_title'] ?: $category['name']) . ' - Custom Apparel Manufacturer USA | Custom Streetwear',
    'meta_description' => $category['seo_description'] ?: "Custom " . $category['name'] . " manufacturing in USA. Premium quality, factory-direct pricing. Custom " . strtolower($category['name']) . " for brands, teams & businesses nationwide.",
    'focus_keyword' => 'Custom ' . $category['name'] . ' Manufacturer USA',
]);
$categoryFaqs = [
    [
        'question' => 'Can Custom Streetwear manufacture custom ' . strtolower($category['name']) . ' for USA buyers?',
        'answer' => 'Yes. Custom Streetwear manufactures custom ' . strtolower($category['name']) . ' for U.S. brands, teams, companies, schools, and organizations with factory-direct production support.'
    ],
    [
        'question' => 'Can this category be customized with logos, colors, and labels?',
        'answer' => 'Yes. Available options include custom colors, logos, embroidery, printing, sublimation, labels, packaging, sizing, and cut-and-sew details depending on the product.'
    ],
    [
        'question' => 'Do you support bulk orders for ' . strtolower($category['name']) . '?',
        'answer' => 'Yes. Bulk and repeat production orders are supported with quoting, artwork review, sampling guidance, and delivery across the USA.'
    ]
];
$extraHead = schemaScript([
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    'name' => 'Custom ' . $category['name'] . ' Manufacturer USA',
    'description' => $category['seo_description'] ?: $category['description'],
    'url' => SITE_URL . '/category/' . $category['slug'],
    'mainEntity' => [
        '@type' => 'ItemList',
        'itemListElement' => array_map(function ($product, $index) {
            return [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $product['title'],
                'url' => SITE_URL . '/product/' . $product['slug']
            ];
        }, $products, array_keys($products))
    ]
]);
$extraHead .= schemaScript(faqSchemaFromRows($categoryFaqs, 'Custom ' . $category['name'] . ' Manufacturer USA FAQ'));

$extraHead .= '<style>
/* Category Description 3D Box */
.cat-desc-3d-wrap{padding:80px 0 40px;background:var(--bg-secondary);border-bottom:1px solid var(--border);position:relative;overflow:hidden;}
.cat-desc-3d-wrap::before{content:"";position:absolute;top:-50%;left:-50%;width:200%;height:200%;background:radial-gradient(circle at 30% 40%,rgba(255,255,255,0.03) 0%,transparent 50%),radial-gradient(circle at 70% 60%,rgba(255,255,255,0.02) 0%,transparent 40%);pointer-events:none;animation:catDescFloat 20s ease-in-out infinite}
@keyframes catDescFloat{0%,100%{transform:translate(0,0) rotate(0deg)}50%{transform:translate(2%,-2%) rotate(1deg)}}
.cat-desc-3d-box{position:relative;max-width:1000px;margin:0 auto;padding:48px;background:linear-gradient(145deg,var(--bg-card) 0%,color-mix(in srgb,var(--bg-card) 90%,var(--bg-secondary)) 100%);border:1px solid var(--border);border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,0.4),0 4px 16px rgba(0,0,0,0.2),inset 0 1px 0 rgba(255,255,255,0.05);transform:perspective(1000px) rotateX(2deg) rotateY(-1deg);transition:transform 0.5s ease,box-shadow 0.5s ease}
.cat-desc-3d-box:hover{transform:perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(-4px);box-shadow:0 32px 80px rgba(0,0,0,0.5),0 8px 24px rgba(0,0,0,0.3),inset 0 1px 0 rgba(255,255,255,0.08)}
.cat-desc-3d-box h2{font-family:var(--font-heading);font-size:clamp(1.3rem,2.5vw,1.8rem);font-weight:700;color:var(--text-primary);margin:32px 0 16px;padding-bottom:12px;border-bottom:2px solid var(--border);line-height:1.3}
.cat-desc-3d-box h2:first-child{margin-top:0;font-size:clamp(1.5rem,3vw,2.2rem);background:linear-gradient(135deg,var(--text-primary) 0%,color-mix(in srgb,var(--text-primary) 70%,var(--accent)) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.cat-desc-3d-box h3{font-family:var(--font-heading);font-size:clamp(1.1rem,2vw,1.4rem);font-weight:600;color:var(--text-primary);margin:24px 0 12px;line-height:1.3}
.cat-desc-3d-box p{font-size:clamp(0.9rem,1.1vw,1rem);color:var(--text-secondary);line-height:1.8;margin-bottom:16px}
.cat-desc-3d-box strong{color:var(--text-primary);font-weight:600}
.cat-desc-3d-box ul,.cat-desc-3d-box ol{margin:16px 0;padding-left:24px}
.cat-desc-3d-box li{font-size:clamp(0.88rem,1vw,0.95rem);color:var(--text-secondary);line-height:1.7;margin-bottom:10px;position:relative;padding-left:16px}
.cat-desc-3d-box li::before{content:"";position:absolute;left:0;top:10px;width:6px;height:6px;background:var(--accent);border-radius:50%;opacity:0.6}
.cat-desc-3d-box ul li::before{content:"▸"}
.cat-desc-3d-box ol{counter-reset:cat-ol}
.cat-desc-3d-box ol li{counter-increment:cat-ol;padding-left:32px}
.cat-desc-3d-box ol li::before{content:counter(cat-ol) ".";position:absolute;left:0;top:0;width:auto;height:auto;background:none;border-radius:0;font-size:0.85rem;color:var(--accent);font-weight:600}
.cat-desc-3d-box a{color:var(--accent);text-decoration:underline;text-underline-offset:3px;transition:opacity 0.3s}
.cat-desc-3d-box a:hover{opacity:0.7}
.cat-desc-3d-box::after{content:"";position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,transparent,var(--accent),transparent);border-radius:20px 20px 0 0;opacity:0.4}

/* Category Hero Cover */
.cat-hero-wrap{position:relative;overflow:hidden}
.cat-hero-wrap img.cat-hero-bg{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;pointer-events:none}
.cat-hero-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(10,10,10,0.88) 0%,rgba(10,10,10,0.92) 100%);pointer-events:none}
.cat-hero-content{position:relative;z-index:1}

/* 3D Get a Quote Button */
.btn-3d{display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:16px 40px;font-family:var(--font-heading);font-size:1rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--inverse-text);background:linear-gradient(145deg,var(--inverse-bg) 0%,color-mix(in srgb,var(--inverse-bg) 85%,var(--accent)) 100%);border:none;border-radius:60px;cursor:pointer;position:relative;transform:translateY(0);box-shadow:0 6px 0 color-mix(in srgb,var(--inverse-bg) 60%,#000),0 10px 30px rgba(0,0,0,0.4),inset 0 1px 0 rgba(255,255,255,0.2);transition:all 0.2s ease;text-decoration:none}
.btn-3d:hover{transform:translateY(-3px);box-shadow:0 10px 0 color-mix(in srgb,var(--inverse-bg) 60%,#000),0 16px 40px rgba(0,0,0,0.5),inset 0 1px 0 rgba(255,255,255,0.3);background:linear-gradient(145deg,color-mix(in srgb,var(--inverse-bg) 90%,var(--accent)) 0%,var(--inverse-bg) 100%)}
.btn-3d:active{transform:translateY(3px);box-shadow:0 2px 0 color-mix(in srgb,var(--inverse-bg) 60%,#000),0 4px 12px rgba(0,0,0,0.3),inset 0 1px 0 rgba(255,255,255,0.1);transition:all 0.1s ease}
.btn-3d::after{content:"";position:absolute;top:3px;left:10%;right:10%;height:40%;background:linear-gradient(180deg,rgba(255,255,255,0.25) 0%,rgba(255,255,255,0) 100%);border-radius:60px;pointer-events:none}

/* Page Heading Section */
.page-heading-section{position:relative;padding:160px 0 60px;overflow:hidden}
.page-heading-bg{position:absolute;inset:0}
.page-heading-bg-img{width:100%;height:100%;object-fit:cover;opacity:0.15}
.page-heading-overlay{position:absolute;inset:0;background:linear-gradient(180deg,var(--bg-primary) 0%,transparent 40%,transparent 60%,var(--bg-primary) 100%)}
.page-heading-content{position:relative;z-index:1;text-align:center}
.hero-label{font-size:0.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.15em;margin-bottom:16px}
.page-main-heading{font-family:var(--font-heading);font-size:clamp(2.5rem,6vw,5rem);font-weight:800;line-height:1.05;margin-bottom:16px}
.page-main-heading .asterisk{color:var(--accent);font-style:italic}
.page-sub-heading{font-size:clamp(0.95rem,1.5vw,1.15rem);color:var(--text-secondary);max-width:600px;margin:0 auto;line-height:1.7}
</style>';

include __DIR__ . '/../includes/header.php';
?>

<?php if (getSetting('site_psycology_first_look', '1') === '1'): ?>
<div class="first-look-elements"><?php echo renderFirstLookElements(); ?></div>
<?php endif; ?>

<!-- Category Hero Section -->
<section class="cat-hero-wrap" style="padding:80px 0 40px;background:var(--bg-secondary);border-bottom:1px solid var(--border);">
    <?php $coverImg = $category['image'] ?: '/uploads/categories/' . $category['slug'] . '.webp'; ?>
    <img class="cat-hero-bg" src="<?php echo e($coverImg); ?>" alt="" onerror="this.style.display='none'">
    <div class="cat-hero-overlay"></div>
    <div class="container cat-hero-content">
        <?php echo advancedBreadcrumb([['label' => 'Products', 'url' => '/#categories'], ['label' => $category['name']]]); ?>
        <div class="reveal">
            <span class="section-label"><?php echo e(getSetting('category_page_label', 'Product Category')); ?></span>
            <h1 style="font-size:clamp(28px,4vw,48px);font-weight:800;margin:8px 0 16px;"><?php echo e($category['name']); ?> - Custom Apparel Manufacturer USA</h1>
            <?php if ($category['description'] && strlen($category['description']) < 300): ?>
            <p style="color:var(--text-muted);max-width:600px;line-height:1.7;"><?php echo e($category['description']); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if ($subcategories): ?>
<section class="section" style="padding:40px 0;border-bottom:1px solid var(--border);">
    <div class="container">
        <h3 style="font-family:var(--font-heading);font-size:16px;text-transform:uppercase;margin-bottom:16px;">Subcategories</h3>
        <div style="display:flex;gap:12px;flex-wrap:wrap;">
            <?php foreach ($subcategories as $sub): ?>
            <a href="/category/<?php echo e($category['slug']); ?>?sub=<?php echo e($sub['slug']); ?>" class="btn btn-outline btn-sm"><?php echo e($sub['name']); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Products Section -->
<section class="section">
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:24px;">
            <p style="font-size:14px;color:var(--text-muted);margin:0;"><strong><?php echo count($products); ?></strong> products found</p>
            <div class="urgency-bar" style="margin:0;">
                <span class="urgency-dot"></span>
                <span>Bulk Orders Welcome | Ships Within 15-20 Days</span>
            </div>
        </div>
        <div class="product-grid">
            <?php if (empty($products)): ?>
            <div style="grid-column:1/-1;text-align:center;padding:60px 0;color:var(--text-muted);">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" opacity="0.3" style="margin:0 auto 16px;display:block;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <p>No products found in this category yet. <a href="/contact" style="color:var(--accent);">Contact us</a> to inquire.</p>
            </div>
            <?php endif; ?>
            <?php foreach ($products as $index => $product): ?>
            <div class="product-card reveal" style="transition-delay:<?php echo $index * 0.1; ?>s;">
                <div class="product-card-image">
                    <img src="<?php echo e($product['main_image'] ?: '/uploads/products/' . $product['slug'] . '.webp'); ?>" alt="<?php echo e($product['alt_text'] ?: $product['title']); ?>" loading="lazy" onerror="this.style.display='none'">
                    <div class="product-card-overlay">
                        <a href="/product/<?php echo e($product['slug']); ?>" class="product-card-action"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></a>
                        <button class="product-card-action" onclick="openQuoteModal()"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></button>
                    </div>
                    <?php if ($product['is_best_seller']): ?><span class="product-card-badge">Best Seller</span><?php endif; ?>
                    <?php if ($product['is_featured']): ?><span class="product-card-badge" style="background:var(--accent);color:#0a0a0a;">Featured</span><?php endif; ?>
                </div>
                <div class="product-card-info">
                    <span class="product-card-category"><?php echo e($product['category_name']); ?></span>
                    <h3 class="product-card-title"><?php echo e($product['title']); ?></h3>
                    <?php if (!empty($product['short_description'])): ?>
                    <p class="product-card-desc"><?php echo e(mb_strimwidth(strip_tags($product['short_description']), 0, 100, '...')); ?></p>
                    <?php endif; ?>
                    <span class="product-card-sku"><?php echo e($product['sku']); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 3D Description Box Section -->
<?php if (!empty($category['description'])): ?>
<section class="cat-desc-3d-wrap">
    <div class="container">
        <div class="cat-desc-3d-box">
            <?php echo htmlspecialchars_decode($category['description'], ENT_QUOTES); ?>
        </div>
        <div style="text-align:center;margin-top:40px;">
            <button class="btn-3d" onclick="openQuoteModal()">Get a Quote</button>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FAQ Section -->
<section class="section" style="background:var(--bg-secondary);">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-label">Technical SEO FAQ</span>
            <h2 class="section-title">Custom <?php echo e($category['name']); ?> Manufacturing FAQ</h2>
            <p class="section-desc">Structured answers for buyers and AI search systems evaluating custom <?php echo e(strtolower($category['name'])); ?> manufacturers in the USA.</p>
        </div>
        <div class="faq-3d-grid reveal">
            <?php foreach ($categoryFaqs as $faq): ?>
            <div class="faq-3d-card">
                <div class="faq-3d-card-inner">
                    <div class="faq-3d-icon">?</div>
                    <h4 class="faq-3d-question"><?php echo e($faq['question']); ?></h4>
                    <p class="faq-3d-answer"><?php echo e($faq['answer']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
