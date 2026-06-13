<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/seo-v2.php';

$hero = dbFetchOne("SELECT * FROM homepage_hero WHERE id = 1 AND status = 1");
$trustBadges = dbFetchAll("SELECT MIN(id) as id, icon, text, sort_order, status FROM homepage_trust_badges WHERE status = 1 GROUP BY text ORDER BY sort_order");
$features = dbFetchAll("SELECT MIN(id) as id, icon, title, subtitle, sort_order, status FROM homepage_features WHERE status = 1 GROUP BY title ORDER BY sort_order");
$categories = dbFetchAll("SELECT MIN(id) as id, title, subtitle, image, link, sort_order, status FROM homepage_categories WHERE status = 1 GROUP BY title ORDER BY sort_order");
$stats = dbFetchAll("SELECT MIN(id) as id, icon, number, label, sort_order, status FROM homepage_stats WHERE status = 1 GROUP BY label ORDER BY sort_order");

$heroImage = $hero['hero_image'] ?? '/uploads/hero-image.png';
if (!file_exists(CSW_ROOT . $heroImage)) {
  $heroImage = '/uploads/default.jpg';
}

$metaTags = generateAdvancedMetaTags([
  'meta_title' => getSetting('home_meta_title', 'Custom Streetwear Manufacturer | Private Label Apparel Factory'),
  'meta_description' => getSetting('home_meta_desc', 'Custom Streetwear is a premium apparel manufacturer in Sialkot, Pakistan, offering custom hoodies, tracksuits, jackets, uniforms, private label clothing and worldwide shipping.'),
  'focus_keyword' => 'Custom Streetwear Manufacturer',
]);

include __DIR__ . '/../includes/header.php';
?>

<!-- ===== PAGE HEADING (ABOVE HERO) ===== -->
<section class="page-heading-section">
  <div class="page-heading-bg">
    <img src="<?php echo e($heroImage); ?>" alt="" class="page-heading-bg-img" onerror="this.style.display='none'">
    <div class="page-heading-overlay"></div>
  </div>
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
  </div>
</section>

<!-- ===== SECTION 01 — HERO ===== -->
<section class="hero-section" id="heroSection">
  <div class="container">
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
        <div class="hero-image-wrap">
          <img src="<?php echo e($heroImage); ?>" alt="Custom Streetwear <?php echo e($hero['label_text'] ?? 'Premium Apparel'); ?>" width="600" height="700" loading="eager">
          <div class="hero-badge">
            <span class="hero-badge-dot"></span>
            Hey, Just An Intro
          </div>
        </div>
        <div class="hero-floating-products">
          <?php $productImages = glob(CSW_ROOT . '/uploads/products/*.jpg'); ?>
          <?php foreach (array_slice($productImages, 0, 3) as $img): ?>
          <div class="hero-floating-item">
            <img src="<?php echo str_replace(CSW_ROOT, '', $img); ?>" alt="Product" loading="lazy">
          </div>
          <?php endforeach; ?>
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

<!-- ===== SECTION 02 — APPROACH / PROCESS ===== -->
<section class="section section-alt" id="process">
  <div class="container">
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

        <div class="progress-section" data-animate="fade-up">
          <div class="progress-item">
            <div class="progress-header">
              <span class="progress-label">Strategy</span>
              <span class="progress-percent">25%</span>
            </div>
            <div class="progress-track">
              <div class="progress-fill" data-width="25">25</div>
            </div>
          </div>
          <div class="progress-item">
            <div class="progress-header">
              <span class="progress-label">Design</span>
              <span class="progress-percent">60%</span>
            </div>
            <div class="progress-track">
              <div class="progress-fill" data-width="60">60</div>
            </div>
          </div>
          <div class="progress-item">
            <div class="progress-header">
              <span class="progress-label">Launch</span>
              <span class="progress-percent">100%</span>
            </div>
            <div class="progress-track">
              <div class="progress-fill" data-width="100">100</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== SECTION 03 — PORTFOLIO / FEATURED WORKS ===== -->
<section class="section" id="portfolio">
  <div class="container">
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

    <div class="partners-row stagger-children" data-animate>
      <?php foreach ($trustBadges as $badge): ?>
      <span class="partner-item"><?php echo e($badge['text']); ?></span>
      <?php endforeach; ?>
    </div>

    <div class="portfolio-grid" data-animate="fade-up">
      <?php foreach (array_slice($categories, 0, 4) as $cat): ?>
      <a href="<?php echo e($cat['link']); ?>" class="portfolio-card">
        <img src="<?php echo e($cat['image']); ?>" alt="<?php echo e($cat['title']); ?>" class="portfolio-card-image" loading="lazy" onerror="this.src='/uploads/default.jpg'">
        <div class="portfolio-card-body">
          <div class="portfolio-card-tags">
            <span class="tag-pill">Featured</span>
            <span class="tag-pill"><?php echo e($cat['subtitle'] ?? 'Custom Apparel'); ?></span>
          </div>
          <h4 class="portfolio-card-title"><?php echo e($cat['title']); ?></h4>
          <span class="portfolio-card-meta">2025 &mdash; Collection</span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===== SECTION 04 — STATS ===== -->
<section class="stats-section" id="stats">
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

<!-- ===== SECTION 05 — SERVICES ===== -->
<section class="section" id="services">
  <div class="container">
    <div class="services-layout">
      <div class="services-left">
        <span class="section-label" data-animate="fade-up">What We Offer</span>
        <h4 class="h4 mt-12" data-animate="fade-up" data-delay="100">Pro Services<span class="serif-mark">&reg;</span></h4>
        <div class="services-marquee" data-animate="fade-up" data-delay="200">
          <div class="services-marquee-track">
            <span class="services-marquee-item">Convert More, Grow Faster</span>
            <span class="services-marquee-item">Convert More, Grow Faster</span>
            <span class="services-marquee-item">Convert More, Grow Faster</span>
          </div>
        </div>
        <div class="services-marquee" data-animate="fade-up" data-delay="300">
          <div class="services-marquee-track reverse">
            <span class="services-marquee-item">Future-Proof &amp; Scalable</span>
            <span class="services-marquee-item">Future-Proof &amp; Scalable</span>
            <span class="services-marquee-item">Future-Proof &amp; Scalable</span>
          </div>
        </div>
        <div class="mt-24" data-animate="fade-up" data-delay="400">
          <a href="/about-us" class="btn btn-ghost">View About <span class="arrow">&rarr;</span></a>
        </div>
      </div>
      <div class="services-right">
        <div class="services-list stagger-children" data-animate>
          <?php foreach ($features as $feat): ?>
          <div class="service-card">
            <div class="service-card-image service-card-icon">
              <span>&#x2713;</span>
            </div>
            <div class="service-card-info">
              <h5><?php echo e($feat['title']); ?></h5>
              <span class="tag-pill service-card-tag"><?php echo e($feat['subtitle'] ?? 'Premium Service'); ?></span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== SECTION 06 — BENEFITS / BENTO GRID ===== -->
<section class="section section-alt" id="benefits">
  <div class="container">
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
          <img src="/uploads/hero-image.png" alt="Production">
        </div>
      </div>
      <div class="bento-card bento-card-small" data-animate="fade-up" data-delay="100">
        <span class="tag-pill">FULL TIME SUPPORT</span>
        <div class="bento-card-support">24/6</div>
        <p class="bento-desc">Round-the-clock support to assist you every step of the way.</p>
      </div>
      <div class="bento-card bento-card-mockup" data-animate="fade-up" data-delay="150">
        <img src="/uploads/products/custom-sublimation-hoodie.jpg" alt="Mobile product preview" onerror="this.src='/uploads/default.jpg'">
      </div>
    </div>
  </div>
</section>

<!-- ===== SECTION 07 — TESTIMONIALS ===== -->
<section class="section" id="testimonials">
  <div class="container">
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

<!-- ===== SECTION 08 — PHOTO GALLERY ===== -->
<section class="section section-alt" id="gallery">
  <div class="container">
    <div class="section-header-inline" data-animate="fade-up">
      <div class="section-title-wrap">
        <span class="section-label">Products By Us</span>
        <h2 class="h2 mt-8">Every Pixel Crafted.<span class="serif-mark">&reg;</span></h2>
      </div>
      <button class="btn btn-sm" onclick="openQuoteModal()">Book an appointment</button>
    </div>
    <div class="gallery-grid stagger-children" data-animate>
      <?php $galleryImages = array_slice($productImages ?? glob(CSW_ROOT . '/uploads/products/*.jpg'), 0, 5); ?>
      <?php foreach ($galleryImages as $img): ?>
      <div class="gallery-item">
        <img src="<?php echo str_replace(CSW_ROOT, '', $img); ?>" alt="Gallery" loading="lazy">
      </div>
      <?php endforeach; ?>
      <?php if (count($galleryImages) < 5): ?>
      <?php for ($i = count($galleryImages); $i < 5; $i++): ?>
      <div class="gallery-item gallery-placeholder">
        <div>Product Image</div>
      </div>
      <?php endfor; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ===== SECTION 09 — PRODUCT CATEGORIES ===== -->
<section class="section section-alt" id="categories">
  <div class="container">
    <div class="section-header" data-animate="fade-up">
      <span class="section-label">Our Collection</span>
      <h2 class="h2 mt-8">Product Categories<span class="serif-mark">&reg;</span></h2>
      <p class="section-desc">Explore our wide range of custom apparel and streetwear categories crafted for brands nationwide.</p>
    </div>

    <div class="categories-grid stagger-children" data-animate>
      <?php
      $dbCategories = dbFetchAll("SELECT id, name, slug, image, description FROM categories WHERE status = 1 ORDER BY sort_order, name");
      if (empty($dbCategories)):
      ?>
      <a href="/category/hoodies" class="category-card">
        <div class="category-card-image">
          <img src="/uploads/categories/hoodies.jpg" alt="Hoodies" loading="lazy" onerror="this.src='/uploads/default.jpg'">
        </div>
        <div class="category-card-body">
          <span class="tag-pill">Category</span>
          <h4 class="category-card-title">Hoodies</h4>
          <span class="category-card-link">Explore &rarr;</span>
        </div>
      </a>
      <a href="/category/tracksuits" class="category-card">
        <div class="category-card-image">
          <img src="/uploads/categories/tracksuits.jpg" alt="Tracksuits" loading="lazy" onerror="this.src='/uploads/default.jpg'">
        </div>
        <div class="category-card-body">
          <span class="tag-pill">Category</span>
          <h4 class="category-card-title">Tracksuits</h4>
          <span class="category-card-link">Explore &rarr;</span>
        </div>
      </a>
      <a href="/category/t-shirts" class="category-card">
        <div class="category-card-image">
          <img src="/uploads/categories/t-shirts.jpg" alt="T-Shirts" loading="lazy" onerror="this.src='/uploads/default.jpg'">
        </div>
        <div class="category-card-body">
          <span class="tag-pill">Category</span>
          <h4 class="category-card-title">T-Shirts</h4>
          <span class="category-card-link">Explore &rarr;</span>
        </div>
      </a>
      <a href="/category/varsity-jackets" class="category-card">
        <div class="category-card-image">
          <img src="/uploads/categories/varsity-jackets.jpg" alt="Varsity Jackets" loading="lazy" onerror="this.src='/uploads/default.jpg'">
        </div>
        <div class="category-card-body">
          <span class="tag-pill">Category</span>
          <h4 class="category-card-title">Varsity Jackets</h4>
          <span class="category-card-link">Explore &rarr;</span>
        </div>
      </a>
      <a href="/category/softshell-jacket" class="category-card">
        <div class="category-card-image">
          <img src="/uploads/categories/softshell-jacket.jpg" alt="Softshell Jacket" loading="lazy" onerror="this.src='/uploads/default.jpg'">
        </div>
        <div class="category-card-body">
          <span class="tag-pill">Category</span>
          <h4 class="category-card-title">Softshell Jackets</h4>
          <span class="category-card-link">Explore &rarr;</span>
        </div>
      </a>
      <a href="/category/sports-uniform" class="category-card">
        <div class="category-card-image">
          <img src="/uploads/categories/sports-uniform.jpg" alt="Sports Uniform" loading="lazy" onerror="this.src='/uploads/default.jpg'">
        </div>
        <div class="category-card-body">
          <span class="tag-pill">Category</span>
          <h4 class="category-card-title">Sports Uniforms</h4>
          <span class="category-card-link">Explore &rarr;</span>
        </div>
      </a>
      <a href="/category/bomber-jackets" class="category-card">
        <div class="category-card-image">
          <img src="/uploads/categories/bomber-jackets.jpg" alt="Bomber Jackets" loading="lazy" onerror="this.src='/uploads/default.jpg'">
        </div>
        <div class="category-card-body">
          <span class="tag-pill">Category</span>
          <h4 class="category-card-title">Bomber Jackets</h4>
          <span class="category-card-link">Explore &rarr;</span>
        </div>
      </a>
      <a href="/category/leather-jackets" class="category-card">
        <div class="category-card-image">
          <img src="/uploads/categories/leather-jackets.jpg" alt="Leather Jackets" loading="lazy" onerror="this.src='/uploads/default.jpg'">
        </div>
        <div class="category-card-body">
          <span class="tag-pill">Category</span>
          <h4 class="category-card-title">Leather Jackets</h4>
          <span class="category-card-link">Explore &rarr;</span>
        </div>
      </a>
      <a href="/category/workwear" class="category-card">
        <div class="category-card-image">
          <img src="/uploads/categories/workwear.jpg" alt="Workwear" loading="lazy" onerror="this.src='/uploads/default.jpg'">
        </div>
        <div class="category-card-body">
          <span class="tag-pill">Category</span>
          <h4 class="category-card-title">Workwear</h4>
          <span class="category-card-link">Explore &rarr;</span>
        </div>
      </a>
      <a href="/category/hospital-uniform" class="category-card">
        <div class="category-card-image">
          <img src="/uploads/categories/hospital-uniform.jpg" alt="Hospital Uniform" loading="lazy" onerror="this.src='/uploads/default.jpg'">
        </div>
        <div class="category-card-body">
          <span class="tag-pill">Category</span>
          <h4 class="category-card-title">Hospital Uniforms</h4>
          <span class="category-card-link">Explore &rarr;</span>
        </div>
      </a>
      <a href="/category/promotional-products" class="category-card">
        <div class="category-card-image">
          <img src="/uploads/categories/promotional-products.jpg" alt="Promotional Products" loading="lazy" onerror="this.src='/uploads/default.jpg'">
        </div>
        <div class="category-card-body">
          <span class="tag-pill">Category</span>
          <h4 class="category-card-title">Promotional Products</h4>
          <span class="category-card-link">Explore &rarr;</span>
        </div>
      </a>
      <a href="/category/winter-coat" class="category-card">
        <div class="category-card-image">
          <img src="/uploads/categories/winter-coat.jpg" alt="Winter Coat" loading="lazy" onerror="this.src='/uploads/default.jpg'">
        </div>
        <div class="category-card-body">
          <span class="tag-pill">Category</span>
          <h4 class="category-card-title">Winter Coats</h4>
          <span class="category-card-link">Explore &rarr;</span>
        </div>
      </a>
      <?php else: ?>
      <?php foreach ($dbCategories as $cat): ?>
      <a href="/category/<?php echo e($cat['slug']); ?>" class="category-card">
        <div class="category-card-image">
          <img src="<?php echo e($cat['image'] ?: '/uploads/categories/' . $cat['slug'] . '.jpg'); ?>" alt="<?php echo e($cat['name']); ?>" loading="lazy" onerror="this.src='/uploads/default.jpg'">
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
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ===== SECTION 10 — BLOG PREVIEW ===== -->
<section class="section section-alt" id="insights">
  <div class="container">
    <div class="section-header-inline" data-animate="fade-up">
      <div class="section-title-wrap">
        <span class="section-label">Latest Updates</span>
        <h2 class="h2 mt-8">Latest Insights.<span class="serif-mark">&reg;</span></h2>
      </div>
      <a href="/blogs" class="section-link">View articles <span class="arrow">&rarr;</span></a>
    </div>
    <div class="blog-grid stagger-children" data-animate>
      <div class="blog-card">
        <img src="/uploads/default.jpg" alt="Blog" class="blog-card-image" loading="lazy">
        <div class="blog-card-body">
          <span class="blog-card-tag">Manufacturing</span>
          <div class="blog-card-date">March 15, 2025</div>
          <h4 class="blog-card-title">The Future of Custom Apparel Manufacturing</h4>
          <a href="/blogs" class="blog-card-link">Read more &rarr;</a>
        </div>
      </div>
      <div class="blog-card">
        <img src="/uploads/default.jpg" alt="Blog" class="blog-card-image" loading="lazy">
        <div class="blog-card-body">
          <span class="blog-card-tag">Design Tips</span>
          <div class="blog-card-date">February 28, 2025</div>
          <h4 class="blog-card-title">How to Design Your Perfect Custom Hoodie</h4>
          <a href="/blogs" class="blog-card-link">Read more &rarr;</a>
        </div>
      </div>
      <div class="blog-card">
        <img src="/uploads/default.jpg" alt="Blog" class="blog-card-image" loading="lazy">
        <div class="blog-card-body">
          <span class="blog-card-tag">Sustainability</span>
          <div class="blog-card-date">January 20, 2025</div>
          <h4 class="blog-card-title">Sustainable Practices in Modern Apparel Production</h4>
          <a href="/blogs" class="blog-card-link">Read more &rarr;</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== SECTION 11 — CONTACT CTA ===== -->
<section class="section" id="contact">
  <div class="container">
    <div class="section-header" data-animate="fade-up">
      <span class="section-label">Let's Work Together</span>
    </div>
    <div class="contact-cta-grid">
      <div class="contact-cta-left" data-animate="fade-up">
        <h4 class="h4 contact-title">Contact Me!</h4>
        <div class="contact-badges contact-badges-top">
          <span class="tag-pill">24/7 Full Time Support</span>
          <span class="tag-pill">Available Worldwide</span>
        </div>
        <button class="btn btn-lg mt-16" onclick="openQuoteModal()">Contact Now</button>
      </div>
      <div class="contact-cta-right" data-animate="fade-up" data-delay="100">
        <form class="contact-form" action="/api/contact.php" method="POST">
          <div class="form-group">
            <label class="form-label" for="contactName">Name</label>
            <input class="form-input" type="text" id="contactName" name="name" placeholder="Your name" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="contactEmail">Email</label>
            <input class="form-input" type="email" id="contactEmail" name="email" placeholder="Your email" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="contactMessage">Message</label>
            <textarea class="form-textarea" id="contactMessage" name="message" placeholder="Tell us about your project..." required></textarea>
          </div>
          <button type="submit" class="form-submit">Submit Now</button>
        </form>
        <img src="/uploads/hero-image.png" alt="Contact" class="contact-portrait" onerror="this.style.display='none'">
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
