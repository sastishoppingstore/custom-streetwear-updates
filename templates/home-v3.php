<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/seo-v2.php';

// File-based query cache
$_cacheFile = sys_get_temp_dir() . '/csw_home_data.cache';
$_cacheTTL = 300;
$_cacheData = null;

if (file_exists($_cacheFile) && (time() - filemtime($_cacheFile)) < $_cacheTTL) {
    $_cacheData = unserialize(file_get_contents($_cacheFile));
}

if ($_cacheData) {
    $hero        = $_cacheData['hero'];
    $trustBadges = $_cacheData['trustBadges'];
    $features    = $_cacheData['features'];
    $categories  = $_cacheData['categories'];
    $stats       = $_cacheData['stats'];
} else {
    $hero        = dbFetchOne("SELECT * FROM homepage_hero WHERE id = 1 AND status = 1");
    $trustBadges = dbFetchAll("SELECT MIN(id) as id, icon, text, sort_order, status FROM homepage_trust_badges WHERE status = 1 GROUP BY text ORDER BY sort_order");
    $features    = dbFetchAll("SELECT MIN(id) as id, icon, title, subtitle, sort_order, status FROM homepage_features WHERE status = 1 GROUP BY title ORDER BY sort_order");
    $categories  = dbFetchAll("SELECT MIN(id) as id, title, subtitle, image, link, sort_order, status FROM homepage_categories WHERE status = 1 GROUP BY title ORDER BY sort_order");
    $stats       = dbFetchAll("SELECT MIN(id) as id, icon, number, label, sort_order, status FROM homepage_stats WHERE status = 1 GROUP BY label ORDER BY sort_order");
    @file_put_contents($_cacheFile, serialize(compact('hero','trustBadges','features','categories','stats')));
}

$heroImage = $hero['hero_image'] ?? '/uploads/hero-image.webp';
if (!file_exists(CSW_ROOT . $heroImage)) {
  $heroImage = '/uploads/hero-image.webp';
}
if (!file_exists(CSW_ROOT . $heroImage)) {
  $heroImage = '/uploads/default.jpg';
}

$_allProductImgs = glob(CSW_ROOT . '/uploads/products/*.webp') ?: [];
if (empty($_allProductImgs)) {
    $_allProductImgs = glob(CSW_ROOT . '/uploads/products/*.jpg') ?: [];
}
$_allProductImgs = array_filter($_allProductImgs, function($f){ return filesize($f) > 5000; });
$_allProductImgs = array_values(array_slice(array_reverse($_allProductImgs), 0, 12));
$_heroSliderImgs = array_map(function($f){ return str_replace(CSW_ROOT, '', $f); }, $_allProductImgs);
$_galleryImgs = array_slice($_heroSliderImgs, 0, 8);
$_products = dbFetchAll("SELECT id, title as name, slug, main_image as image, short_description FROM products WHERE status = 1 ORDER BY sort_order, id LIMIT 8");
$_dbCats = dbFetchAll("SELECT id, name, slug, image, description FROM categories WHERE status = 1 ORDER BY sort_order, name LIMIT 4");

$cutIntroImage = $heroImage;
$cutPortfolioImage = !empty($categories[0]['image']) ? $categories[0]['image'] : (!empty($_dbCats[0]['image']) ? $_dbCats[0]['image'] : (!empty($_heroSliderImgs[0]) ? $_heroSliderImgs[0] : $heroImage));
$cutBenefitsImage = '/uploads/fashion-bg.jpg';
if (!file_exists(CSW_ROOT . $cutBenefitsImage)) {
    $cutBenefitsImage = '/uploads/products/custom-sublimation-hoodie.webp';
}
if (!file_exists(CSW_ROOT . $cutBenefitsImage)) {
    $cutBenefitsImage = !empty($_heroSliderImgs[1]) ? $_heroSliderImgs[1] : $heroImage;
}
$cutShotsImage = '/uploads/factory-bg.jpg';
if (!file_exists(CSW_ROOT . $cutShotsImage)) {
    $cutShotsImage = !empty($_heroSliderImgs[2]) ? $_heroSliderImgs[2] : (!empty($_heroSliderImgs[0]) ? $_heroSliderImgs[0] : $heroImage);
}
$cutUpdatesImage = '/uploads/blog-bg.jpg';
if (!file_exists(CSW_ROOT . $cutUpdatesImage)) {
    $cutUpdatesImage = '/uploads/blogs/blog-1.webp';
}
if (!file_exists(CSW_ROOT . $cutUpdatesImage)) {
    $cutUpdatesImage = $heroImage;
}

$metaTags = generateAdvancedMetaTags([
  'meta_title' => getSetting('home_meta_title', 'Custom Streetwear Manufacturer | Private Label Apparel Factory'),
  'meta_description' => getSetting('home_meta_desc', 'Custom Streetwear is a premium apparel manufacturer in Sialkot, Pakistan, offering custom hoodies, tracksuits, jackets, uniforms, private label clothing and worldwide shipping.'),
  'focus_keyword' => 'Custom Streetwear Manufacturer',
]);

include __DIR__ . '/../includes/header.php';
?>

<div class="viper-scroll-stack">

<!-- ===== CUT GROUP 01 — INTRO ===== -->
<div class="viper-cut-wrapper viper-cut-intro" id="introReveal">
  <div class="viper-sticky-image">
    <img src="<?php echo e($cutIntroImage); ?>" alt="Custom Streetwear intro background" onerror="this.src='/uploads/default.jpg'">
  </div>

  <section class="hero-section viper-cut-content" id="heroSection">
    <div class="container">
    <div class="page-heading-content">
      <div class="hero-label" data-animate="fade-up">&copy;2025</div>
      <h1 class="page-main-heading" data-animate="fade-up" data-delay="100">
        <?php echo e($hero['main_heading'] ?? 'Premium Custom Streetwear'); ?><span class="asterisk">*</span>
      </h1>
      <p class="page-sub-heading" data-animate="fade-up" data-delay="200">
        <?php echo e($hero['subheading'] ?? 'Custom Streetwear is a leading manufacturer of custom clothing. Crafted with precision. Worn with purpose.'); ?>
      </p>
    </div>

    <div class="hero-grid">
      <div class="hero-content">
        <div class="hero-features" data-animate="fade-up" data-delay="300">
          <div class="hero-feature">
            <div class="hero-feature-icon">&#x2713;</div>
            <div class="hero-feature-text">
              <h5>Bringing Ideas to Life</h5>
              <p>From concept to creation — we manufacture custom apparel that represents your brand.</p>
            </div>
          </div>
          <div class="hero-feature">
            <div class="hero-feature-icon">&#x2713;</div>
            <div class="hero-feature-text">
              <h5>Collaborate with Me</h5>
              <p>Work closely with our expert team to bring your custom clothing vision to reality.</p>
            </div>
          </div>
        </div>
        <div data-animate="fade-up" data-delay="400">
          <button class="btn btn-lg" onclick="openQuoteModal()">Get in Touch</button>
        </div>
      </div>

      <div class="hero-visual" data-animate="fade" data-delay="500">
        <div class="hero-image-wrap" style="position: relative;">
          <img src="<?php echo e($heroImage); ?>" alt="Custom Streetwear <?php echo e($hero['label_text'] ?? 'Premium Apparel'); ?>" width="600" height="700" loading="eager" onerror="this.style.display='none'">
          <div class="hero-badge">
            <span class="hero-badge-dot"></span>
            Hey, Just An Intro
          </div>

          <div class="hero-floating-slider" id="heroFloatingSlider">
            <div class="hero-floating-track" id="heroFloatingTrack">
              <?php foreach ($_heroSliderImgs as $idx => $imgPath): ?>
              <div class="hero-floating-item<?php echo $idx === 0 ? ' active' : ''; ?>" data-index="<?php echo $idx; ?>">
                <img src="<?php echo e($imgPath); ?>" alt="Product <?php echo $idx+1; ?>" loading="<?php echo $idx < 3 ? 'eager' : 'lazy'; ?>" onerror="this.parentElement.style.display='none'">
              </div>
              <?php endforeach; ?>
              <?php if (empty($_heroSliderImgs)): ?>
              <div class="hero-floating-item active">
                <img src="/uploads/default.jpg" alt="Product">
              </div>
              <?php endif; ?>
            </div>
            <?php if (count($_heroSliderImgs) > 1): ?>
            <div class="hero-slider-controls">
              <button class="hero-slider-btn hero-slider-prev" id="heroSliderPrev" aria-label="Previous product">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15,18 9,12 15,6"/></svg>
              </button>
              <span class="hero-slider-count" id="heroSliderCount">1 / <?php echo count($_heroSliderImgs); ?></span>
              <button class="hero-slider-btn hero-slider-next" id="heroSliderNext" aria-label="Next product">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9,18 15,12 9,6"/></svg>
              </button>
            </div>
            <?php endif; ?>
          </div>
        </div>

        <div class="logo-ticker">
          <div class="logo-track">
            <?php for ($i = 0; $i < 2; $i++): ?>
            <?php foreach ($trustBadges as $badge): ?>
            <div class="logo-track-item"><span><?php echo e($badge['text']); ?></span></div>
            <?php endforeach; ?>
            <?php endfor; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  </section>
</div>

<!-- ===== SECTION 02 — APPROACH / PROCESS ===== -->
<section class="section section-alt" id="process" style="position:relative; z-index:5;">
  <div class="container">
    <div class="viper-section-meta">
      <span class="viper-section-tag"><span class="viper-dot"></span>Approach Style</span>
      <span>(CQ&reg; &mdash; 02)</span>
      <span>&copy;2025</span>
    </div>
    <div class="process-section">
      <div class="process-left">
        <span class="section-label" data-animate="fade-up">Approach Style</span>
        <div class="counter-row" data-animate="fade-up" data-delay="100">
          <span class="section-counter">(CQ&reg; &mdash; 02)</span>
          <span class="section-counter">&copy;2025</span>
        </div>
      </div>
      <div class="process-right">
        <div class="process-step" data-animate="fade-up">
          <div class="process-step-number">01</div>
          <h5 class="process-step-title">Consultation &amp; Design</h5>
          <div class="process-step-desc">We begin by understanding your vision, requirements, and brand identity. Our design team creates detailed mockups and samples to ensure every detail aligns with your expectations.</div>
        </div>
        <div class="process-step" data-animate="fade-up" data-delay="100">
          <div class="process-step-number">02</div>
          <h5 class="process-step-title">Production &amp; Quality Control</h5>
          <div class="process-step-desc">Using state-of-the-art machinery and premium materials, we manufacture your order with precision. Every garment undergoes 12-point quality inspection before packaging.</div>
        </div>
        <div class="process-step" data-animate="fade-up" data-delay="200">
          <div class="process-step-number">03</div>
          <h5 class="process-step-title">Delivery &amp; Support</h5>
          <div class="process-step-desc">We handle global logistics and shipping with real-time tracking. Our support team remains available 24/6 to assist with any post-delivery needs.</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== CUT GROUP 02 — FEATURED WORKS ===== -->
<div class="viper-cut-wrapper viper-cut-featured" id="featuredWorksReveal">
  <div class="viper-sticky-image">
    <img src="<?php echo e($cutPortfolioImage); ?>" alt="Featured works background" onerror="this.src='/uploads/default.jpg'">
  </div>

<section class="section viper-cut-content" id="portfolio">
  <div class="container">
    <div class="viper-section-meta">
      <span class="viper-section-tag"><span class="viper-dot"></span>Featured Works</span>
      <span>(CQ&reg; &mdash; 03)</span>
      <span>&copy;2025</span>
    </div>
    <div class="section-header-inline" data-animate="fade-up">
      <div class="section-title-wrap">
        <span class="section-label">Featured Works</span>
        <div class="title-tag-row">
          <span class="tag-pill">Portfolio</span>
        </div>
        <h2 class="h2 mt-12">Featured Portfolio<span class="serif-mark">&reg;</span></h2>
      </div>
      <a href="/category/all" class="section-link">View portfolio <span class="arrow">&rarr;</span></a>
    </div>

    <div class="portfolio-grid" data-animate="fade-up">
      <?php
      $portfolioItems = !empty($categories) ? array_slice($categories, 0, 4) : [];
      if (empty($portfolioItems) && !empty($_dbCats)) {
          $portfolioItems = array_map(function($c) {
              return [
                  'title' => $c['name'],
                  'subtitle' => strip_tags($c['description'] ?? 'Custom Apparel'),
                  'image' => $c['image'] ?: '/uploads/categories/' . $c['slug'] . '.webp',
                  'link' => '/category/' . $c['slug'],
              ];
          }, $_dbCats);
      }
      foreach ($portfolioItems as $idx => $cat):
      ?>
      <a href="<?php echo e($cat['link']); ?>" class="portfolio-card">
        <div class="portfolio-card-img-wrap">
          <img src="<?php echo e($cat['image']); ?>" alt="<?php echo e($cat['title']); ?>" class="portfolio-card-image" loading="lazy" onerror="this.src='/uploads/default.jpg'">
          <div class="portfolio-card-overlay-tags">
            <span class="tag-pill">Featured</span>
            <span class="tag-pill"><?php echo e($cat['subtitle'] ?? 'Custom Apparel'); ?></span>
          </div>
        </div>
        <div class="portfolio-card-body">
          <h4 class="portfolio-card-title"><?php echo e($cat['title']); ?></h4>
          <span class="portfolio-card-meta">2025 &mdash; Collection</span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
</div>

<!-- ===== SECTION 04 — STATS ===== -->
<section class="stats-section" id="stats" style="position:relative; z-index:5;">
  <div class="container">
    <div class="stats-header" data-animate="fade-up">
      <h3 class="h3 measure-lg">Numbers that speak volumes about our commitment to quality and excellence.</h3>
    </div>
    <div class="stats-grid">
      <?php foreach ($stats as $stat): ?>
      <div class="stat-item" data-animate="fade-up">
        <div class="stat-number" data-counter="<?php echo e(preg_replace('/[^0-9]/', '', $stat['number'])); ?>">0+</div>
        <div class="stat-label"><?php echo e($stat['label']); ?></div>
        <div class="stat-desc">Delivering consistent quality and service worldwide.</div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===== CUT GROUP 03 — BENEFITS ===== -->
<div class="viper-cut-wrapper viper-cut-benefits" id="benefitsReveal">
  <div class="viper-sticky-image">
    <img src="<?php echo e($cutBenefitsImage); ?>" alt="Benefits background" onerror="this.src='/uploads/default.jpg'">
  </div>

<section class="section section-alt viper-cut-content" id="benefits">
  <div class="container">
    <div class="viper-section-meta">
      <span class="viper-section-tag"><span class="viper-dot"></span>Why Choose Us</span>
      <span>(CQ&reg; &mdash; 06)</span>
      <span>&copy;2025</span>
    </div>
    <div class="section-header" data-animate="fade-up">
      <span class="section-label">Why Choose Us</span>
      <h2 class="h2 mt-8">Built Different.<span class="serif-mark">&reg;</span></h2>
    </div>
    <div class="bento-grid">
      <div class="bento-card bento-card-wide bento-bg-hero">
        <div class="bento-bg-blur"></div>
        <div class="bento-content" data-animate="fade-up">
          <span class="tag-pill self-start">Lightning Fast</span>
          <h3 class="bento-heading">It takes 15&ndash;20 Days to launch your custom apparel.</h3>
          <p class="bento-desc">Lightning-fast delivery without compromising quality.</p>
        </div>
      </div>
      <div class="bento-card bento-card-tall" data-animate="fade-up">
        <span class="tag-pill">All in one platform</span>
        <h4 class="bento-kicker">FROM 0 TO 100<br>IN ONE SMALL STEP</h4>
        <div class="bento-image-slot">
          <img src="<?php echo e($heroImage); ?>" alt="Production" loading="lazy">
        </div>
      </div>
      <div class="bento-card bento-card-small" data-animate="fade-up" data-delay="100">
        <span class="tag-pill">FULL TIME SUPPORT</span>
        <div class="bento-card-support">24/6</div>
        <p class="bento-desc">Round-the-clock support to assist you every step of the way.</p>
      </div>
      <div class="bento-card bento-card-mockup" data-animate="fade-up" data-delay="150">
        <img src="/uploads/products/custom-sublimation-hoodie.webp" alt="Mobile product preview" onerror="this.src='/uploads/products/custom-sublimation-hoodie.jpg';this.onerror=function(){this.src='/uploads/default.jpg'}">
      </div>
    </div>
  </div>
</section>
</div>

<!-- ===== SECTION 07 — TESTIMONIALS ===== -->
<section class="section" id="testimonials" style="position:relative; z-index:5;">
  <div class="container">
    <div class="viper-section-meta">
      <span class="viper-section-tag"><span class="viper-dot"></span>Voices</span>
      <span>(CQ&reg; &mdash; 07)</span>
      <span>&copy;2025</span>
    </div>
    <div class="section-header-inline" data-animate="fade-up">
      <div class="section-title-wrap">
        <span class="section-label">Voices</span>
        <h4 class="h4 mt-8">Trusted By Experts.</h4>
      </div>
      <button class="btn btn-sm" onclick="openQuoteModal()">Become a partner</button>
    </div>
    <div class="testimonials-scroll" data-animate="fade-up">
      <?php
      $testimonials = [
        ['name' => 'James Mitchell', 'role' => 'CEO', 'company' => 'Mitchell Sports', 'text' => 'The quality and attention to detail exceeded our expectations. Our team uniforms have never looked better. The turnaround time was impressive and the communication throughout was excellent.'],
        ['name' => 'Sarah Chen', 'role' => 'Founder', 'company' => 'Urban Threads', 'text' => 'Working with Custom Streetwear has been transformative for our brand. Their ability to handle complex customizations with consistent quality makes them our go-to manufacturer.'],
        ['name' => 'Marcus Williams', 'role' => 'Operations Director', 'company' => 'Premier Athletics', 'text' => 'We have partnered with many manufacturers over the years, but none have delivered the level of service and quality that Custom Streetwear provides. Highly recommended.'],
      ];
      foreach ($testimonials as $t):
      ?>
      <div class="testimonial-card">
        <div class="testimonial-author">
          <div class="testimonial-avatar testimonial-avatar-initial">
            <span><?php echo e(substr($t['name'], 0, 1)); ?></span>
          </div>
          <div class="testimonial-meta">
            <h5><?php echo e($t['name']); ?></h5>
            <span><?php echo e($t['role']); ?>, <?php echo e($t['company']); ?></span>
          </div>
        </div>
        <div class="testimonial-social">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          <span>@customstreetwear</span>
        </div>
        <p class="testimonial-text">"<?php echo e($t['text']); ?>"</p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===== CUT GROUP 04 — SHOTS BY ME (PERFECT 100% FRAMER COVERFLOW) ===== -->
<div class="viper-cut-wrapper viper-cut-shots" id="shotsReveal">
  <div class="viper-sticky-image">
    <img src="<?php echo e($cutShotsImage); ?>" alt="Shots by me background" onerror="this.src='/uploads/default.jpg'">
  </div>

<section class="section viper-cut-content" id="gallery">
  <div class="container">
    <div class="viper-section-meta">
      <span class="viper-section-tag"><span class="viper-dot"></span>Products By Us</span>
      <span>(CQ&reg; &mdash; 08)</span>
      <span>&copy;2025</span>
    </div>
    <div class="viper-shots-header" data-animate="fade-up">
      <span class="tag-pill">Products</span>
      <h2 class="viper-shots-title">Every Pixel Crafted.<span class="serif-mark">&reg;</span></h2>
      <p class="viper-shots-desc">Crafting custom apparel with precision. Through our factory, we produce stunning garments that bring your brand to life with quality, style, and impact.</p>
      <button class="btn-3d" onclick="openQuoteModal()">
        Get a Quote
      </button>
    </div>
  </div>

  <!-- EXACT 100% FRAMER COVERFLOW -->
  <div class="viper-fan-wrap" id="viperFanWrap">
    <?php
    $fanImgs = array_slice($_heroSliderImgs, 0, 7);
    
    // YAHAN VALUES PERFECT KI GAYI HAIN! SPREAD OUTWARD.
    $fanTX     = [-350, -180, -70, 0, 70, 180, 350];  // Negative for Left, Positive for Right!
    $fanRZ     = [0, 0, 0, 0, 0, 0, 0];             
    $fanRY     = [50, 35, 15, 0, -15, -35, -50];    // 3D inward curve
    $fanY      = [0, 0, 0, 0, 0, 0, 0];             
    $fanScale  = [2.0, 1.5, 1.15, 0.9, 1.15, 1.5, 2.0]; // Outer cards massive, center small
    $fanBright = [0.3, 0.6, 0.85, 1, 0.85, 0.6, 0.3];   
    $fanZindex = [10, 9, 8, 7, 8, 9, 10];           // Outer overlaps inner

    foreach ($fanImgs as $fi => $fimg):
      $tx = $fanTX[$fi] ?? 0;
      $rz = $fanRZ[$fi] ?? 0;
      $ry = $fanRY[$fi] ?? 0;
      $ty = $fanY[$fi] ?? 0;
      $sc = $fanScale[$fi] ?? 1;
      $br = $fanBright[$fi] ?? 1;
      $zi = $fanZindex[$fi] ?? 1;
    ?>
    <a href="/category/all" class="viper-fan-card" style="--fan-tx:<?php echo $tx; ?>px; --fan-rz:<?php echo $rz; ?>deg; --fan-ry:<?php echo $ry; ?>deg; --fan-y:<?php echo $ty; ?>px; --fan-scale:<?php echo $sc; ?>; --fan-bright:<?php echo $br; ?>; z-index: <?php echo $zi; ?>;">
      <img src="<?php echo e($fimg); ?>" alt="Product <?php echo $fi+1; ?>" loading="lazy" onerror="this.parentElement.style.display='none'">
    </a>
    <?php endforeach; ?>
    
    <?php if (empty($fanImgs)): for($fi=0;$fi<7;$fi++): ?>
    <div class="viper-fan-card" style="--fan-tx:<?php echo ($fanTX[$fi]??0); ?>px; --fan-rz:<?php echo ($fanRZ[$fi]??0); ?>deg; --fan-ry:<?php echo ($fanRY[$fi]??0); ?>deg; --fan-y:<?php echo ($fanY[$fi]??0); ?>px; z-index: <?php echo ($fanZindex[$fi]??1); ?>;">
      <div style="width:100%;height:100%;background:var(--bg-card);display:flex;align-items:center;justify-content:center;color:var(--text-muted);font-size:.8rem;">Product</div>
    </div>
    <?php endfor; endif; ?>
  </div>
</section>
</div>

<!-- ===== SECTION 09 — PRODUCT CATEGORIES ===== -->
<section class="section section-alt" id="categories" style="position:relative; z-index:5;">
  <div class="container">
    <div class="viper-section-meta">
      <span class="viper-section-tag"><span class="viper-dot"></span>Our Collection</span>
      <span>(CQ&reg; &mdash; 09)</span>
      <span>&copy;2025</span>
    </div>
    <div class="section-header" data-animate="fade-up">
      <span class="section-label">Our Collection</span>
      <h2 class="h2 mt-8">Product Categories<span class="serif-mark">&reg;</span></h2>
    </div>

    <div class="categories-grid stagger-children" data-animate>
      <?php
      $dbCategories = dbFetchAll("SELECT id, name, slug, image, description FROM categories WHERE status = 1 ORDER BY sort_order, name");
      foreach ($dbCategories as $cat): ?>
      <a href="/category/<?php echo e($cat['slug']); ?>" class="category-card">
        <div class="category-card-image">
          <img src="<?php echo e($cat['image'] ?: '/uploads/categories/' . $cat['slug'] . '.webp'); ?>" alt="<?php echo e($cat['name']); ?>" loading="lazy" onerror="this.style.display='none'">
        </div>
        <div class="category-card-body">
          <span class="tag-pill">Category</span>
          <h4 class="category-card-title"><?php echo e($cat['name']); ?></h4>
          <?php if (!empty($cat['description'])): ?>
          <p class="category-card-desc"><?php echo e(mb_strimwidth(strip_tags(htmlspecialchars_decode($cat['description'])), 0, 120, '...')); ?></p>
          <?php endif; ?>
          <span class="category-card-link">Explore &rarr;</span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===== CUT GROUP 05 — LATEST UPDATES ===== -->
<div class="viper-cut-wrapper viper-cut-updates" id="latestUpdatesReveal">
  <div class="viper-sticky-image">
    <img src="<?php echo e($cutUpdatesImage); ?>" alt="Latest updates background" onerror="this.src='/uploads/default.jpg'">
  </div>

<section class="section section-alt viper-cut-content" id="insights">
  <div class="container">
    <div class="viper-section-meta">
      <span class="viper-section-tag"><span class="viper-dot"></span>Latest Updates</span>
      <span>(CQ&reg; &mdash; 12)</span>
      <span>&copy;2025</span>
    </div>
    <div class="section-header-inline" data-animate="fade-up">
      <div class="section-title-wrap">
        <span class="section-label">Latest Updates</span>
        <h2 class="h2 mt-8">Latest Insights.<span class="serif-mark">&reg;</span></h2>
      </div>
      <a href="/blogs" class="section-link">View articles <span class="arrow">&rarr;</span></a>
    </div>
    <div class="blog-grid stagger-children" data-animate>
      <div class="blog-card">
        <img src="/uploads/blogs/blog-1.webp" alt="Blog" class="blog-card-image" loading="lazy" onerror="this.src='/uploads/default.jpg'">
        <div class="blog-card-body">
          <span class="blog-card-tag">Manufacturing</span>
          <div class="blog-card-date">March 15, 2025</div>
          <h4 class="blog-card-title">The Future of Custom Apparel Manufacturing</h4>
          <a href="/blogs" class="blog-card-link">Read more &rarr;</a>
        </div>
      </div>
    </div>
  </div>
</section>
</div>

<!-- ===== SECTION 13 — CONTACT CTA (VIPER MATCH) ===== -->
<section class="section" id="contactCTA" style="position:relative; z-index:5;">
  <div class="container">
    <div class="viper-section-meta">
      <span class="viper-section-tag"><span class="viper-dot"></span>Contact Now</span>
      <span>(CQ&reg; &mdash; 13)</span>
      <span>&copy;2025</span>
    </div>
    <div class="contact-cta-grid" data-animate="fade-up">
      <div class="contact-cta-left">
        <span class="section-label">Contact Now</span>
        <h2 class="h2 mt-8">Let's Work Together.<span class="serif-mark">&reg;</span></h2>
        <p class="body-text mt-16">Let's create something amazing together! Reach out &mdash; I'd love to hear about your project and ideas.</p>
        <div class="contact-badges" style="margin-top: 24px;">
          <span class="tag-pill">24/7 Full Time Support</span>
          <span class="tag-pill">Available Worldwide</span>
        </div>
        <div style="margin-top: 32px;">
          <button class="btn btn-lg" onclick="openQuoteModal()">Contact Now</button>
        </div>
      </div>
      <div class="contact-cta-right">
        <form class="contact-form" onsubmit="event.preventDefault(); openQuoteModal();">
          <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-input" placeholder="Your name" required>
          </div>
          <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-input" placeholder="your@email.com" required>
          </div>
          <div class="form-group">
            <label class="form-label">Project Details</label>
            <textarea class="form-textarea" placeholder="Tell us about your project..." rows="4"></textarea>
          </div>
          <button type="submit" class="form-submit">Send Message</button>
        </form>
      </div>
    </div>
  </div>
</section>

</div><!-- /.viper-scroll-stack -->

<?php include __DIR__ . '/../includes/footer.php'; ?>