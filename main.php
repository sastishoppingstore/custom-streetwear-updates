<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Premium Custom Streetwear - Apparel Manufacturer in Miami, Florida. Custom Apparel Manufacturer in USA. Hoodies, Jackets, Tracksuits & more.">
    <title><?= isset($pageTitle) ? Security::escape($pageTitle) . ' - ' : '' ?>STREETWEAR.CO</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/css/optimize-images.css">
</head>
<body>
    <div class="page-loader">
        <span class="loader-text">STREETWEAR.CO</span>
    </div>
    <nav class="main-nav site-nav">
        <div class="nav-container">
            <div class="nav-left">
                <a href="/" class="nav-logo">
                    <span class="logo-icon"></span>
                    <span class="logo-text">STREETWEAR.CO</span>
                </a>
            </div>
            
            <div class="nav-links desktop-only">
                <a href="/" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/' ? 'active' : '' ?>">Home <sup>01</sup></a>
                <a href="/about" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/about') === 0 ? 'active' : '' ?>">About <sup>02</sup></a>
                <a href="/work" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/work') === 0 ? 'active' : '' ?>">Work <sup>03</sup></a>
                <a href="/blog" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/blog') === 0 ? 'active' : '' ?>">Insights <sup>04</sup></a>
            </div>
            
            <div class="nav-right">
                <a href="/contact" class="btn-outline">Get in Touch</a>
                <button class="btn-diamond">
                    <span class="diamond-icon">◇</span>
                </button>
                <button class="hamburger mobile-only">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>
            </div>
        </div>
    </nav>
    
    <div class="mobile-menu">
        <div class="mobile-menu-content">
            <a href="/" class="mobile-link">Home</a>
            <a href="/about" class="mobile-link">About</a>
            <a href="/work" class="mobile-link">Work</a>
            <a href="/blog" class="mobile-link">Insights</a>
            <a href="/contact" class="mobile-link">Contact</a>
        </div>
    </div>
    
    <main>
        <?php echo $content ?? ''; ?>
    </main>
    
    <footer class="site-footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-left">
                    <div class="footer-logo">
                        <span class="logo-icon"></span>
                        <span class="logo-text">STREETWEAR.CO</span>
                    </div>
                    <h3 class="footer-heading">Stay Connected<span class="reg-mark">®</span></h3>
                    <a href="mailto:hello@premiumstreetwear.co" class="footer-email">hello@premiumstreetwear.co</a>
                    <p class="footer-tagline">USA's premier custom streetwear manufacturer based in Miami, Florida.</p>
                    <a href="/contact" class="btn-outline">Contact Now</a>
                </div>
                
                <div class="footer-right">
                    <nav class="footer-nav">
                        <a href="/" class="footer-nav-link"><span class="link-num">01</span> / Home</a>
                        <a href="/about" class="footer-nav-link"><span class="link-num">02</span> / About</a>
                        <a href="/work" class="footer-nav-link"><span class="link-num">03</span> / Work</a>
                        <a href="/blog" class="footer-nav-link"><span class="link-num">04</span> / Insights</a>
                        <a href="/contact" class="footer-nav-link"><span class="link-num">05</span> / Contact</a>
                    </nav>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p class="footer-copyright">Copyright © Premium Custom Streetwear 2025</p>
                <div class="footer-diamond">
                    <span class="diamond-icon">◇</span>
                </div>
                <a href="#" class="back-to-top">©Back to top</a>
            </div>
        </div>
        
        <video class="footer-video" autoplay muted loop playsinline poster="/uploads/sliders/slider-1.jpg">
            <source src="data:," type="video/mp4">
        </video>
    </footer>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="/public/js/fast-image-loader.js"></script>
    <script src="/public/js/main.js"></script>
</body>
</html>
