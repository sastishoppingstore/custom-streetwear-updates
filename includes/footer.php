<?php
$siteName = getSetting('site_name', 'Custom Streetwear');
$sitePhone = getSetting('site_phone', '');
$siteEmail = getSetting('site_email', '');
$siteAddress = getSetting('site_address', '');
$footerText = getSetting('footer_text', '');
$copyright = getSetting('copyright_text', 'Custom Streetwear. All Rights Reserved.');
$whatsapp = getSetting('whatsapp_button_number', '');
$logoText = getSetting('site_logo_text', 'CUSTOM STREETWEAR');
$logoImage = getSetting('site_logo_image', '/uploads/settings/logo.webp');
$navItems = [
  ['label' => 'Home', 'url' => '/', 'num' => '01'],
  ['label' => 'About', 'url' => '/about-us', 'num' => '02'],
  ['label' => 'Work', 'url' => '/category/all', 'num' => '03'],
  ['label' => 'Insights', 'url' => '/blogs', 'num' => '04'],
  ['label' => 'Contact', 'url' => '/contact', 'num' => '05'],
];
// Fetch reviews from DB for the blinking strip
$footerReviews = dbFetchAll("SELECT client_name AS reviewer_name, message AS review_text, rating, company FROM testimonials WHERE status = 1 AND rating >= 4 ORDER BY sort_order LIMIT 20");
if (empty($footerReviews)) {
    $footerReviews = dbFetchAll("SELECT reviewer_name, review_text, rating FROM site_reviews ORDER BY sort_order LIMIT 20");
}
$footerReviewsJson = json_encode(array_map(function($r) {
    return ['n' => e($r['reviewer_name'] ?? ''), 't' => e($r['review_text'] ?? ''), 's' => intval($r['rating'] ?? 5)];
}, $footerReviews ?: []));
?>
  </main>

  <footer class="site-footer">
    <div class="footer-container">
      <div class="footer-top-section">
        <div class="footer-hero-image">
          <img src="/assets/images/factory-bg.jpg" alt="Factory" loading="lazy">
        </div>
        <div class="footer-logo-overlay">
          <?php if ($logoImage): ?>
          <img src="<?php echo e($logoImage); ?>" alt="<?php echo e($siteName); ?>" class="footer-logo-image">
          <?php else: ?>
          <span class="footer-logo-text"><?php echo e($logoText); ?></span>
          <?php endif; ?>
        </div>
      </div>
      <div class="footer-middle">
        <div class="footer-content">
          <div class="footer-email-section">
            <div class="footer-tagline">Stay connected<span class="serif-mark">&reg;</span></div>
            <a href="mailto:<?php echo e($siteEmail); ?>" class="footer-email"><?php echo e($siteEmail); ?></a>
            <p class="footer-desc"><?php echo e($footerText ?: 'Premium custom apparel manufacturer delivering quality since 2012.'); ?></p>
            <button class="btn btn-outline" onclick="openQuoteModal()">Contact Now</button>
          </div>
          <nav class="footer-nav">
            <?php foreach ($navItems as $item): ?>
            <a href="<?php echo e($item['url']); ?>">
              <sup><?php echo e($item['num']); ?></sup> <?php echo e($item['label']); ?>
            </a>
            <?php endforeach; ?>
          </nav>
        </div>
      </div>
      <div class="footer-bottom">
        <span class="footer-copy">Copyright &copy; <?php echo e($siteName); ?> <?php echo date('Y'); ?></span>
        <button class="back-to-top" onclick="window.scrollTo({top:0,behavior:'smooth'})">
          &copy;Back to top
        </button>
      </div>
    </div>
  </footer>

  <?php include __DIR__ . '/quote-modal.php'; ?>
  <?php echo gtmBody(); ?>
  <?php echo customBodyCode(); ?>
  <script src="/assets/js/viper-main.js?v=<?php echo filemtime(CSW_ROOT . '/assets/js/viper-main.js'); ?>"></script>
  <script src="/assets/js/viper-animations.js?v=<?php echo filemtime(CSW_ROOT . '/assets/js/viper-animations.js'); ?>"></script>
  <?php echo $extraFoot ?? ''; ?>

  <a href="https://wa.me/92<?php echo ltrim(ltrim($whatsapp, '0'), '+'); ?>?text=Hi%20Custom%20Streetwear%2C%20I%20need%20a%20quote" class="whatsapp-float" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
    <svg viewBox="0 0 24 24" width="28" height="28" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
  </a>

<style>
.csw-notification{position:fixed;bottom:100px;left:24px;z-index:9998;max-width:380px;background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:16px 20px;box-shadow:0 12px 40px rgba(0,0,0,0.4);transform:translateX(-120%) rotateY(-10deg);opacity:0;transition:transform 0.6s cubic-bezier(0.34,1.56,0.64,1),opacity 0.5s ease;transform-style:preserve-3d;pointer-events:none}.csw-notification.show{transform:translateX(0) rotateY(0);opacity:1}.csw-notification-inner{display:flex;align-items:center;gap:14px}.csw-noti-icon{width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,#25d366,#128c7e);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.2rem;flex-shrink:0}.csw-noti-text{flex:1}.csw-noti-name{font-weight:700;font-size:.9rem;color:var(--text-primary);margin-bottom:2px}.csw-noti-prod{font-size:.8rem;color:var(--text-secondary);margin-bottom:2px}.csw-noti-time{font-size:.7rem;color:var(--text-muted)}.csw-noti-badge{font-size:.65rem;background:var(--badge-bg);border:1px solid var(--badge-border);padding:2px 10px;border-radius:50px;color:var(--text-secondary);white-space:nowrap}

.csw-review-strip{position:fixed;bottom:24px;left:50%;transform:translateX(-50%);z-index:9997;background:var(--bg-card);border:1px solid var(--border);border-radius:50px;padding:10px 24px;box-shadow:0 8px 32px rgba(0,0,0,0.3);display:flex;align-items:center;gap:12px;max-width:90vw;animation:cswPulse 2s ease-in-out infinite;pointer-events:none}.csw-review-stars{color:#ffc107;font-size:1rem;letter-spacing:2px;flex-shrink:0}.csw-review-text{font-size:.82rem;color:var(--text-secondary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.csw-review-author{font-size:.72rem;color:var(--text-muted);flex-shrink:0}.csw-review-strip.out{animation:cswFadeOut 0.5s ease forwards}@keyframes cswPulse{0%,100%{opacity:1;transform:translateX(-50%) scale(1)}50%{opacity:0.85;transform:translateX(-50%) scale(1.02)}}@keyframes cswFadeOut{to{opacity:0;transform:translateX(-50%) translateY(20px)}}
</style>

<script>
(function(){var orders=[{n:"James Mitchell",c:"New York, NY",p:"Custom Hoodies",t:"12 min ago"},{n:"Sarah Chen",c:"Los Angeles, CA",p:"Varsity Jackets",t:"18 min ago"},{n:"Marcus Williams",c:"Chicago, IL",p:"Tracksuits",t:"23 min ago"},{n:"Emily Rodriguez",c:"Miami, FL",p:"Custom T-Shirts",t:"31 min ago"},{n:"David Kim",c:"Seattle, WA",p:"Bomber Jackets",t:"42 min ago"},{n:"Jennifer Adams",c:"Houston, TX",p:"Sports Uniforms",t:"8 min ago"},{n:"Michael Thompson",c:"Dallas, TX",p:"Leather Jackets",t:"15 min ago"},{n:"Amanda Foster",c:"San Diego, CA",p:"Softshell Jackets",t:"27 min ago"},{n:"Robert Johnson",c:"Phoenix, AZ",p:"Polo Shirts",t:"35 min ago"},{n:"Jessica Lee",c:"Denver, CO",p:"Sweatshirts",t:"5 min ago"},{n:"Christopher Brown",c:"Atlanta, GA",p:"Motorcycle Jackets",t:"11 min ago"},{n:"Stephanie Taylor",c:"Portland, OR",p:"Custom Hoodies",t:"19 min ago"},{n:"Daniel Martinez",c:"Boston, MA",p:"Tracksuits",t:"28 min ago"},{n:"Lauren White",c:"Nashville, TN",p:"Winter Coats",t:"38 min ago"},{n:"Kevin Anderson",c:"Charlotte, NC",p:"Varsity Jackets",t:"45 min ago"},{n:"Rachel Green",c:"Austin, TX",p:"Custom T-Shirts",t:"7 min ago"},{n:"Brandon Davis",c:"San Francisco, CA",p:"Bomber Jackets",t:"14 min ago"},{n:"Megan Wilson",c:"Philadelphia, PA",p:"Sports Uniforms",t:"22 min ago"}];var dbReviews=<?php echo $footerReviewsJson; ?>;var defaultReviews=[{s:5,t:"Amazing quality! Fast delivery. Highly recommend.",a:"- Alex R."},{s:5,t:"Best manufacturer in USA. Consistent quality every time.",a:"- Sarah C."},{s:4,t:"Great communication and fast sampling process.",a:"- Marcus W."},{s:5,t:"Transformed our brand. Sold out in 48 hours!",a:"- James M."},{s:4,t:"Reliable partner for bulk orders. Will order again.",a:"- Lisa K."},{s:5,t:"Incredible attention to detail. World-class factory.",a:"- David K."},{s:4,t:"Fast turnaround, premium quality packaging.",a:"- Rachel G."},{s:5,t:"They handle everything from design to shipping.",a:"- Michael T."}];var reviews=dbReviews&&dbReviews.length?dbReviews.map(function(r){return{s:r.s,t:r.t,a:'- '+r.n}}):defaultReviews;var oi=0,ri=0;function showOrder(){var o=orders[oi%orders.length];var el=document.querySelector('.csw-notification');el.querySelector('.csw-noti-name').textContent=o.n;el.querySelector('.csw-noti-prod').textContent=o.p+' \u2022 '+o.c;el.querySelector('.csw-noti-time').textContent=o.t;el.classList.add('show');setTimeout(function(){el.classList.remove('show')},5000);oi++}function showReview(){var r=reviews[ri%reviews.length];var el=document.querySelector('.csw-review-strip');el.querySelector('.csw-review-stars').textContent='\u2605'.repeat(r.s)+'\u2606'.repeat(5-r.s);el.querySelector('.csw-review-text').textContent=r.t;el.querySelector('.csw-review-author').textContent=r.a;el.classList.remove('out');setTimeout(function(){el.classList.add('out')},6000);ri++}var noti=document.createElement('div');noti.className='csw-notification';noti.innerHTML='<div class="csw-notification-inner"><div class="csw-noti-icon">&#x2709;</div><div class="csw-noti-text"><div class="csw-noti-name"></div><div class="csw-noti-prod"></div><div class="csw-noti-time"></div></div><div class="csw-noti-badge">New Order</div></div>';document.body.appendChild(noti);var rev=document.createElement('div');rev.className='csw-review-strip';rev.innerHTML='<span class="csw-review-stars"></span><span class="csw-review-text"></span><span class="csw-review-author"></span>';document.body.appendChild(rev);setTimeout(function(){showOrder();showReview()},2000);setInterval(showOrder,15000);setInterval(showReview,10000)})();
</script>

</body>
</html>
