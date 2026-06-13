/**
 * Custom Streetwear v2 - Enhanced Main JavaScript
 * Psychology-based interactions, advanced animations
 */

document.addEventListener('DOMContentLoaded', function() {
    initMobileMenu();
    initHeroSlider();
    initScrollReveal();
    initBackToTop();
    initStickyHeader();
    initSmoothScroll();
    initProductGallery();
    initProductTabs();
    initCounters();
    initFaqAccordion();
    initFaqSearch();
    initFaqCategories();
    initMagneticEffect();
    init3DTilt();
    initPageTransition();
    initSmoothAnchorLinks();
});

/* ========================================
   MOBILE MENU
   ======================================== */
function initMobileMenu() {}

function toggleMobileMenu() {
    const drawer = document.getElementById('mobileDrawer');
    const overlay = document.getElementById('mobileDrawerOverlay');
    const hamburger = document.getElementById('mobileHamburger');
    const body = document.body;

    if (!drawer || !overlay || !hamburger) return;

    const isActive = drawer.classList.contains('active');

    if (isActive) {
        drawer.classList.remove('active');
        overlay.classList.remove('active');
        hamburger.classList.remove('active');
        body.classList.remove('menu-open');
        body.style.overflow = '';
    } else {
        drawer.classList.add('active');
        overlay.classList.add('active');
        hamburger.classList.add('active');
        body.classList.add('menu-open');
        body.style.overflow = 'hidden';
    }
}

function toggleMobileSubmenu(element) {
    const item = element.closest('.mobile-menu-item');
    if (item) item.classList.toggle('active');
}

/* ========================================
   HERO SLIDER
   ======================================== */
let currentSlide = 0;
let slideInterval;

function initHeroSlider() {
    const slides = document.querySelectorAll('.hero-slide');
    if (slides.length === 0) return;
    showSlide(0);
    startAutoSlide();
}

function showSlide(index) {
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-dot');
    if (slides.length === 0) return;
    
    slides.forEach((slide, i) => {
        slide.classList.toggle('active', i === index);
    });
    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
    });
    currentSlide = index;
}

function nextSlide() {
    const slides = document.querySelectorAll('.hero-slide');
    showSlide((currentSlide + 1) % slides.length);
}

function prevSlide() {
    const slides = document.querySelectorAll('.hero-slide');
    showSlide((currentSlide - 1 + slides.length) % slides.length);
}

function goToSlide(index) {
    showSlide(index);
    resetAutoSlide();
}

function startAutoSlide() {
    slideInterval = setInterval(nextSlide, 5000);
}

function resetAutoSlide() {
    clearInterval(slideInterval);
    startAutoSlide();
}

/* ========================================
   TRACKING EVENTS
   ======================================== */
function trackConversionEvent(eventName, params = {}) {
    const payload = Object.assign({ page_path: window.location.pathname }, params);

    if (window.dataLayer && Array.isArray(window.dataLayer)) {
        window.dataLayer.push(Object.assign({ event: eventName }, payload));
    }
    if (typeof window.gtag === 'function') {
        window.gtag('event', eventName, payload);
    }
    if (typeof window.fbq === 'function') {
        const fbEvent = eventName === 'quote_submit' ? 'Lead' : (eventName === 'order_submit' ? 'Purchase' : 'Contact');
        window.fbq('track', fbEvent, payload);
    }
    if (window.ttq && typeof window.ttq.track === 'function') {
        const ttEvent = eventName === 'quote_submit' ? 'SubmitForm' : (eventName === 'order_submit' ? 'CompletePayment' : 'Contact');
        window.ttq.track(ttEvent, payload);
    }
}

/* ========================================
   QUOTE MODAL
   ======================================== */
function openQuoteModal() {
    const modal = document.getElementById('quoteModal');
    const overlay = document.getElementById('quoteModalOverlay');
    if (!modal || !overlay) return;
    modal.classList.add('active');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeQuoteModal() {
    const modal = document.getElementById('quoteModal');
    const overlay = document.getElementById('quoteModalOverlay');
    if (!modal || !overlay) return;
    modal.classList.remove('active');
    overlay.classList.remove('active');
    
    const drawer = document.getElementById('mobileDrawer');
    if (drawer && drawer.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
        document.body.classList.remove('menu-open');
    }
    
    const form = document.getElementById('quoteForm');
    const success = document.getElementById('quoteSuccess');
    if (form) form.style.display = 'block';
    if (success) success.style.display = 'none';
    if (form) form.reset();
}

function submitQuoteForm(event) {
    event.preventDefault();
    const form = event.target;
    const btn = document.getElementById('quoteSubmitBtn');
    const btnText = btn.querySelector('.btn-text');
    const btnLoader = btn.querySelector('.btn-loader');
    
    btn.disabled = true;
    if (btnText) btnText.style.display = 'none';
    if (btnLoader) btnLoader.style.display = 'inline-flex';
    
    fetch('/api/quote.php', {
        method: 'POST',
        body: new FormData(form)
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            form.style.display = 'none';
            document.getElementById('quoteSuccess').style.display = 'block';
            trackConversionEvent('quote_submit', {
                form_name: 'quote',
                product_interest: form.querySelector('[name="product_interest"]')?.value || '',
                quantity: form.querySelector('[name="quantity"]')?.value || ''
            });
        } else {
            alert(data.message || 'Something went wrong.');
        }
    })
    .catch(() => alert('Failed to submit. Please contact us directly.'))
    .finally(() => {
        btn.disabled = false;
        if (btnText) btnText.style.display = '';
        if (btnLoader) btnLoader.style.display = 'none';
    });
}

/* ========================================
   SCROLL REVEAL - Enhanced
   ======================================== */
function initScrollReveal() {
    const revealEls = document.querySelectorAll('.reveal');
    const staggerEls = document.querySelectorAll('.reveal-stagger');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });
    
    revealEls.forEach(el => observer.observe(el));
    staggerEls.forEach(el => observer.observe(el));
}

/* ========================================
   BACK TO TOP
   ======================================== */
function initBackToTop() {
    const btn = document.getElementById('backToTop');
    if (!btn) return;
    
    window.addEventListener('scroll', function() {
        btn.classList.toggle('visible', window.scrollY > 500);
    }, { passive: true });
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

/* ========================================
   STICKY HEADER
   ======================================== */
function initStickyHeader() {
    const header = document.getElementById('mainHeader');
    const topBar = document.getElementById('topBar');
    if (!header) return;
    
    window.addEventListener('scroll', function() {
        const scrolled = window.scrollY > 100;
        header.style.boxShadow = scrolled ? '0 4px 30px rgba(0,0,0,0.3)' : 'none';
        
        if (topBar) {
            topBar.style.transform = window.scrollY > 50 ? 'translateY(-100%)' : 'translateY(0)';
            topBar.style.opacity = window.scrollY > 50 ? '0' : '1';
        }
    }, { passive: true });
}

/* ========================================
   FAQ ACCORDION
   ======================================== */
function initFaqAccordion() {
    document.querySelectorAll('.faq-question').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.faq-item');
            if (!item) return;
            
            const isActive = item.classList.contains('active');
            
            // Close all others
            document.querySelectorAll('.faq-item.active').forEach(el => {
                if (el !== item) {
                    el.classList.remove('active');
                    const answer = el.querySelector('.faq-answer');
                    if (answer) answer.style.maxHeight = '0';
                }
            });
            
            // Toggle current
            item.classList.toggle('active');
            const answer = item.querySelector('.faq-answer');
            if (answer) {
                answer.style.maxHeight = isActive ? '0' : answer.scrollHeight + 'px';
            }
        });
    });
    
    // Open first FAQ by default
    const firstFaq = document.querySelector('.faq-item');
    if (firstFaq && !document.querySelector('.faq-item.active')) {
        firstFaq.classList.add('active');
        const firstAnswer = firstFaq.querySelector('.faq-answer');
        if (firstAnswer) firstAnswer.style.maxHeight = firstAnswer.scrollHeight + 'px';
    }
}

/* ========================================
   FAQ SEARCH
   ======================================== */
function initFaqSearch() {
    const searchInput = document.getElementById('faqSearch');
    if (!searchInput) return;
    
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        const items = document.querySelectorAll('.faq-item');
        let visibleCount = 0;
        
        items.forEach(item => {
            const question = item.querySelector('.faq-question').textContent.toLowerCase();
            const answer = item.querySelector('.faq-answer-inner')?.textContent.toLowerCase() || '';
            
            if (!query || question.includes(query) || answer.includes(query)) {
                item.style.display = '';
                visibleCount++;
                // Highlight matches
                if (query) {
                    const qText = item.querySelector('.faq-question');
                    qText.innerHTML = highlightText(qText.textContent, query);
                }
            } else {
                item.style.display = 'none';
            }
        });
        
        // Show/hide no results
        const noResults = document.getElementById('faqNoResults');
        if (noResults) {
            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    });
}

function highlightText(text, query) {
    const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
    return text.replace(regex, '<mark style="background:rgba(57,255,20,0.2);color:var(--color-accent);padding:0 2px;border-radius:2px;">$1</mark>');
}

/* ========================================
   FAQ CATEGORY FILTER
   ======================================== */
function initFaqCategories() {
    document.querySelectorAll('.faq-category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.dataset.category;
            
            document.querySelectorAll('.faq-category-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            if (category === 'all') {
                document.querySelectorAll('.faq-section').forEach(s => s.style.display = '');
            } else {
                document.querySelectorAll('.faq-section').forEach(s => {
                    s.style.display = s.dataset.category === category ? '' : 'none';
                });
            }
        });
    });
}

/* ========================================
   MAGNETIC HOVER EFFECT
   ======================================== */
function initMagneticEffect() {
    document.querySelectorAll('.magnetic').forEach(el => {
        el.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            this.style.transform = `translate(${x * 0.1}px, ${y * 0.1}px)`;
        });
        
        el.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });
}

/* ========================================
   3D TILT EFFECT ON CARDS
   ======================================== */
function init3DTilt() {
    document.querySelectorAll('.glass-card, .product-card').forEach(card => {
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;
            this.style.transform = `perspective(1000px) rotateY(${x * 5}deg) rotateX(${-y * 5}deg) translateY(-8px)`;
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });
}

/* ========================================
   PAGE TRANSITION
   ======================================== */
function initPageTransition() {
    document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript"])').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href.startsWith('/') && !href.startsWith('//')) {
                e.preventDefault();
                document.body.classList.add('page-leaving');
                setTimeout(() => {
                    window.location.href = href;
                }, 300);
            }
        });
    });
}

/* ========================================
   SMOOTH ANCHOR LINKS
   ======================================== */
function initSmoothAnchorLinks() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                const headerHeight = document.getElementById('mainHeader')?.offsetHeight || 0;
                const top = target.getBoundingClientRect().top + window.scrollY - headerHeight - 20;
                window.scrollTo({ top, behavior: 'smooth' });
            }
        });
    });
}

/* ========================================
   PRODUCT GALLERY
   ======================================== */
function initProductGallery() {
    const mainImage = document.getElementById('productMainImage');
    const thumbs = document.querySelectorAll('.gallery-thumb');
    if (!mainImage || thumbs.length === 0) return;
    
    thumbs.forEach(thumb => {
        thumb.addEventListener('click', function() {
            const img = this.querySelector('img');
            if (img) {
                mainImage.src = img.src;
                mainImage.alt = img.alt;
                thumbs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });
}

/* ========================================
   PRODUCT TABS
   ======================================== */
function initProductTabs() {
    const tabBtns = document.querySelectorAll('.product-tab-btn');
    const tabPanels = document.querySelectorAll('.product-tab-panel');
    if (tabBtns.length === 0) return;
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const target = this.dataset.tab;
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            tabPanels.forEach(p => p.classList.toggle('active', p.id === target));
        });
    });
}

/* ========================================
   ANIMATED COUNTERS
   ======================================== */
function initCounters() {
    const counters = document.querySelectorAll('[data-counter]');
    if (counters.length === 0) return;
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    counters.forEach(c => observer.observe(c));
}

function animateCounter(element) {
    const target = parseInt(element.dataset.counter);
    const duration = 2000;
    const step = Math.ceil(target / (duration / 16));
    let current = 0;
    
    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            element.textContent = target.toLocaleString();
            clearInterval(timer);
        } else {
            element.textContent = current.toLocaleString();
        }
    }, 16);
}

/* ========================================
   UTILITY
   ======================================== */
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeQuoteModal();
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenu?.classList.contains('active')) toggleMobileMenu();
    }
});


/* ========================================
   3D PARALLAX HERO EFFECT
   ======================================== */
function init3DParallaxHero() {
    const heroWrapper = document.querySelector('.hero-3d-wrapper');
    if (!heroWrapper) return;
    
    heroWrapper.addEventListener('mousemove', function(e) {
        const rect = this.getBoundingClientRect();
        const x = (e.clientX - rect.left) / rect.width - 0.5;
        const y = (e.clientY - rect.top) / rect.height - 0.5;
        
        const layers = this.querySelectorAll('.hero-layer');
        layers.forEach((layer, index) => {
            const depth = (index + 1) * 10;
            const moveX = x * depth;
            const moveY = y * depth;
            layer.style.transform = `translate3d(${moveX}px, ${moveY}px, ${depth}px)`;
        });
    });
    
    heroWrapper.addEventListener('mouseleave', function() {
        const layers = this.querySelectorAll('.hero-layer');
        layers.forEach((layer, index) => {
            const depth = (index + 1) * 10;
            layer.style.transform = `translate3d(0, 0, ${depth}px)`;
        });
    });
}

/* ========================================
   MAGNETIC CURSOR INTERACTION
   ======================================== */
function initMagneticCursor() {
    const magneticElements = document.querySelectorAll('.magnetic-area, .btn, .category-card, .product-card');
    
    magneticElements.forEach(el => {
        el.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            const strength = 0.15;
            
            this.style.transform = `translate(${x * strength}px, ${y * strength}px)`;
        });
        
        el.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });
}

/* ========================================
   INTERSECTION OBSERVER SCROLL REVEAL
   ======================================== */
function initAdvancedScrollReveal() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    const revealElements = document.querySelectorAll('.reveal, .reveal-stagger, .reveal-scale, .reveal-left, .reveal-right');
    revealElements.forEach(el => observer.observe(el));
}

/* ========================================
   LIVE VISITOR COUNTER (Psychology)
   ======================================== */
function initLiveStats() {
    const statElements = document.querySelectorAll('.live-stat-count');
    
    statElements.forEach(el => {
        const baseCount = parseInt(el.textContent) || 24;
        
        setInterval(() => {
            const variation = Math.floor(Math.random() * 5) - 2;
            const newCount = Math.max(10, baseCount + variation);
            el.textContent = newCount;
        }, 8000);
    });
}

/* ========================================
   COUNTDOWN TIMER (Urgency)
   ======================================== */
function initCountdownTimer() {
    const timerElement = document.querySelector('.countdown-time');
    if (!timerElement) return;
    
    let minutes = 14;
    let seconds = 59;
    
    setInterval(() => {
        seconds--;
        if (seconds < 0) {
            minutes--;
            seconds = 59;
        }
        if (minutes < 0) {
            minutes = 14;
            seconds = 59;
        }
        
        timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }, 1000);
}

/* ========================================
   TESTIMONIAL TICKER (Social Proof)
   ======================================== */
function initTestimonialTicker() {
    const testimonials = [
        { name: 'John M.', location: 'Los Angeles, CA', message: 'Just ordered 50 custom hoodies! Quality looks amazing!' },
        { name: 'Sarah K.', location: 'New York, NY', message: 'Perfect for our team uniforms. Fast service!' },
        { name: 'Mike R.', location: 'Chicago, IL', message: 'Best pricing I found anywhere. Highly recommend!' },
        { name: 'Lisa T.', location: 'Miami, FL', message: 'Third order this year. Never disappointed!' },
        { name: 'David P.', location: 'Seattle, WA', message: 'Custom jackets came out perfect. Thanks!' }
    ];
    
    let currentIndex = 0;
    
    function showTicker() {
        const ticker = document.querySelector('.testimonial-ticker');
        if (ticker) ticker.remove();
        
        const data = testimonials[currentIndex];
        const tickerHTML = `
            <div class="testimonial-ticker">
                <button class="ticker-close" onclick="document.querySelector('.testimonial-ticker').remove()">×</button>
                <div class="ticker-header">
                    <div class="ticker-avatar"></div>
                    <div class="ticker-info">
                        <div class="ticker-name">${data.name}</div>
                        <div class="ticker-time">Just ordered from ${data.location}</div>
                    </div>
                </div>
                <div class="ticker-message">${data.message}</div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', tickerHTML);
        
        setTimeout(() => {
            const ticker = document.querySelector('.testimonial-ticker');
            if (ticker) ticker.remove();
        }, 8000);
        
        currentIndex = (currentIndex + 1) % testimonials.length;
    }
    
    setTimeout(showTicker, 5000);
    setInterval(showTicker, 25000);
}

/* ========================================
   CARD HOVER 3D TILT
   ======================================== */
function init3DCardTilt() {
    const cards = document.querySelectorAll('.glass-card, .category-card, .product-card');
    
    cards.forEach(card => {
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;
            
            this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-8px)`;
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });
}

/* ========================================
   INIT ALL EFFECTS
   ======================================== */
document.addEventListener('DOMContentLoaded', function() {
    init3DParallaxHero();
    initMagneticCursor();
    initAdvancedScrollReveal();
    initLiveStats();
    initCountdownTimer();
    initTestimonialTicker();
    init3DCardTilt();
});
