<?php
$headerMenu = getMenu('header');
$siteName = getSetting('site_name', 'Custom Streetwear');
$sitePhone = getSetting('site_phone', '');
$siteEmail = getSetting('site_email', '');
$siteAddress = getSetting('site_address', '');
$logoText = getSetting('site_logo_text', 'CUSTOM STREETWEAR');
$logoTagline = getSetting('site_logo_tagline', 'Custom Apparel Manufacturer');
$logoImage = getSetting('site_logo_image', '/uploads/settings/logo.webp');
$favicon = getSetting('favicon', getSetting('site_favicon', '/uploads/settings/favicon.ico'));
$appleTouchIcon = getSetting('site_apple_touch_icon', $favicon);
$icon192 = getSetting('site_favicon_192', $favicon);
$icon512 = getSetting('site_favicon_512', $icon192);
$themeColor = '#ffffff';
$navItems = [
  ['label' => 'Home', 'url' => '/', 'num' => '01'],
  ['label' => 'About', 'url' => '/about-us', 'num' => '02'],
  ['label' => 'Work', 'url' => '/category/all', 'num' => '03'],
  ['label' => 'Blog', 'url' => '/blogs', 'num' => '04'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php echo $metaTags ?? generateMetaTags(); ?>
  <?php echo hreflangTags(); ?>
  <link rel="icon" type="image/x-icon" href="<?php echo e($favicon); ?>">
  <link rel="shortcut icon" href="<?php echo e($favicon); ?>">
  <link rel="apple-touch-icon" href="<?php echo e($appleTouchIcon); ?>">
  <meta name="theme-color" content="<?php echo e($themeColor); ?>">
  <script>
  (function() {
    var stored = localStorage.getItem('csw-theme');
    var preferred = window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', stored || preferred);
  })();
  </script>
  <style><?php echo file_get_contents(CSW_ROOT . '/assets/css/critical-v3.css'); ?></style>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/viper-theme.css?v=<?php echo filemtime(CSW_ROOT . '/assets/css/viper-theme.css'); ?>">
  <link rel="stylesheet" href="/assets/css/viper-animations.css?v=<?php echo filemtime(CSW_ROOT . '/assets/css/viper-animations.css'); ?>">
  <script type="application/ld+json"><?php echo organizationSchema(); ?></script>
  <?php echo gtmHead(); ?>
  <?php echo customHeadCode(); ?>
  <?php echo $extraHead ?? ''; ?>
    <link rel="stylesheet" href="/public/css/optimize-images.css">
  <style>
.btn-3d{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:10px 28px;font-family:var(--font-heading);font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--inverse-text);background:linear-gradient(145deg,var(--inverse-bg),color-mix(in srgb,var(--inverse-bg) 85%,var(--accent)));border:none;border-radius:50px;cursor:pointer;position:relative;box-shadow:0 4px 0 color-mix(in srgb,var(--inverse-bg) 60%,#000),0 8px 24px rgba(0,0,0,0.35),inset 0 1px 0 rgba(255,255,255,0.2);transition:all 0.2s ease;text-decoration:none;line-height:1}
.btn-3d:hover{transform:translateY(-2px);box-shadow:0 7px 0 color-mix(in srgb,var(--inverse-bg) 60%,#000),0 14px 36px rgba(0,0,0,0.45),inset 0 1px 0 rgba(255,255,255,0.3)}
.btn-3d:active{transform:translateY(2px);box-shadow:0 1px 0 color-mix(in srgb,var(--inverse-bg) 60%,#000),0 3px 10px rgba(0,0,0,0.3),inset 0 1px 0 rgba(255,255,255,0.1);transition:all 0.08s ease}
.btn-3d::after{content:"";position:absolute;top:2px;left:12%;right:12%;height:35%;background:linear-gradient(180deg,rgba(255,255,255,0.22),rgba(255,255,255,0));border-radius:50px;pointer-events:none}
</style>
</head>
<body>
  <header class="site-header" id="siteHeader">
    <div class="header-inner">
      <a href="/" class="header-logo" aria-label="<?php echo e($siteName); ?> - Home">
        <?php if ($logoImage): ?>
        <img src="<?php echo e($logoImage); ?>" alt="<?php echo e($siteName); ?>">
        <?php else: ?>
        <?php echo e($logoText); ?>
        <?php endif; ?>
      </a>
      <nav class="header-nav" aria-label="Main Navigation">
        <?php foreach ($navItems as $i => $item): ?>
        <a href="<?php echo e($item['url']); ?>" class="<?php echo isCurrentPage($item['url']) ? 'active' : ''; ?>">
          <?php echo e($item['label']); ?><sup><?php echo e($item['num']); ?></sup>
        </a>
        <?php endforeach; ?>
      </nav>
      <div class="header-cta">
        <button class="btn-3d" onclick="openQuoteModal()">Get in touch</button>
        <button class="theme-toggle" type="button" data-theme-toggle aria-label="Switch theme" aria-pressed="false">
          <span class="theme-toggle-icon theme-toggle-sun" aria-hidden="true"></span>
          <span class="theme-toggle-icon theme-toggle-moon" aria-hidden="true"></span>
        </button>
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
  </header>

  <div class="mobile-drawer" id="mobileDrawer">
    <nav class="mobile-nav-list">
      <?php foreach ($navItems as $i => $item): ?>
      <a href="<?php echo e($item['url']); ?>">
        <?php echo e($item['label']); ?><sup><?php echo e($item['num']); ?></sup>
      </a>
      <?php endforeach; ?>
    </nav>
    <div class="mobile-drawer-footer">
      <button class="theme-toggle theme-toggle-wide" type="button" data-theme-toggle aria-label="Switch theme" aria-pressed="false">
        <span class="theme-toggle-icon theme-toggle-sun" aria-hidden="true"></span>
        <span class="theme-toggle-icon theme-toggle-moon" aria-hidden="true"></span>
        <span class="theme-toggle-label">Theme</span>
      </button>
      <button class="btn-3d" style="width:100%;padding:14px 28px;" onclick="openQuoteModal(); document.getElementById('menuToggle').click();">
        Get in touch
      </button>
    </div>
  </div>

  <main id="mainContent">
