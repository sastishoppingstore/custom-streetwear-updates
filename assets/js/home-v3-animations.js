/**
 * Homepage V3 Animations - Optimized for all network speeds
 * Vanilla JavaScript with performance optimizations
 */

(function() {
    'use strict';

    if (window.homeV3Loaded) return;
    window.homeV3Loaded = true;

    // ========== Mobile Menu Toggle ==========
    window.toggleMobileMenu = function() {
        const drawer = document.getElementById('mobileDrawer');
        const overlay = document.getElementById('mobileDrawerOverlay');
        const hamburger = document.getElementById('mobileHamburger');
        const body = document.body;

        if (drawer && overlay && hamburger) {
            const isActive = drawer.classList.contains('active');
            
            if (isActive) {
                drawer.classList.remove('active');
                overlay.classList.remove('active');
                hamburger.classList.remove('active');
                body.classList.remove('menu-open');
            } else {
                drawer.classList.add('active');
                overlay.classList.add('active');
                hamburger.classList.add('active');
                body.classList.add('menu-open');
            }
        }
    };

    window.toggleMobileSubmenu = function(element) {
        const menuItem = element.closest('.mobile-menu-item');
        if (menuItem) {
            menuItem.classList.toggle('active');
        }
    };

    // ========== Sticky Header on Scroll ==========
    function initStickyHeader() {
        const header = document.getElementById('mainHeader');
        if (!header) return;

        let ticking = false;
        function updateHeader() {
            if (window.pageYOffset > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(updateHeader);
                ticking = true;
            }
        }, { passive: true });
    }

    // ========== Scroll Animations ==========
    function initScrollAnimations() {
        const elements = document.querySelectorAll('[data-animate]');
        if (!elements.length) return;
        
        if (!('IntersectionObserver' in window)) {
            elements.forEach(function(el) { el.classList.add('visible'); });
            return;
        }

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const delay = entry.target.getAttribute('data-delay') || 0;
                    setTimeout(function() {
                        entry.target.classList.add('visible');
                    }, parseInt(delay));
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        elements.forEach(function(el) { observer.observe(el); });
    }

    // ========== Hero Particles ==========
    function initHeroParticles() {
        const container = document.getElementById('heroParticles');
        if (!container) return;

        const isMobile = window.innerWidth < 768;
        const particleCount = isMobile ? 20 : 40;
        const fragment = document.createDocumentFragment();
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            const size = Math.random() * 2 + 1;
            const startX = Math.random() * 100;
            const startY = Math.random() * 100;
            const duration = Math.random() * 15 + 10;
            const delay = Math.random() * 3;
            
            particle.style.cssText = `
                position: absolute; width: ${size}px; height: ${size}px;
                background: rgba(57, 255, 20, ${Math.random() * 0.4 + 0.2});
                border-radius: 50%; left: ${startX}%; top: ${startY}%;
                animation: float ${duration}s ${delay}s infinite ease-in-out;
                will-change: transform, opacity;
            `;
            fragment.appendChild(particle);
        }
        container.appendChild(fragment);

        if (!document.getElementById('particleStyles')) {
            const style = document.createElement('style');
            style.id = 'particleStyles';
            style.textContent = `
                @keyframes float {
                    0%, 100% { transform: translate(0, 0); opacity: 0; }
                    10% { opacity: 1; }
                    90% { opacity: 1; }
                    100% { transform: translate(${Math.random() * 80 - 40}px, ${Math.random() * 80 - 40}px); opacity: 0; }
                }
            `;
            document.head.appendChild(style);
        }
    }

    // ========== Counter Animation ==========
    function initCounters() {
        const counters = document.querySelectorAll('[data-counter]');
        if (!counters.length) return;
        
        if (!('IntersectionObserver' in window)) {
            counters.forEach(function(counter) {
                counter.textContent = parseInt(counter.getAttribute('data-counter'));
            });
            return;
        }

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const target = parseInt(element.getAttribute('data-counter'));
                    const duration = 2000;
                    const increment = target / (duration / 16);
                    let current = 0;

                    const timer = setInterval(function() {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        const displayValue = Math.floor(current);
                        const originalText = element.textContent;
                        let newText = displayValue.toString();
                        if (originalText.includes('+')) newText += '+';
                        if (originalText.includes('%')) newText += '%';
                        element.textContent = newText;
                    }, 16);
                    observer.unobserve(element);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(function(counter) { observer.observe(counter); });
    }

    // ========== Image Load Error Handler ==========
    function initImageErrorHandling() {
        const images = document.querySelectorAll('img');
        images.forEach(function(img) {
            if (!img.hasAttribute('onerror')) {
                img.onerror = function() {
                    this.onerror = null;
                    this.src = '/uploads/default.jpg';
                };
            }
        });
    }

    // ========== SLOW MOVE PARALLAX FOR STICKY IMAGES ==========
    function initCutRevealParallax() {
        const wrappers = document.querySelectorAll('.viper-cut-wrapper');
        if (!wrappers.length) return;

        window.addEventListener('scroll', function() {
            window.requestAnimationFrame(function() {
                wrappers.forEach(function(wrapper) {
                    const img = wrapper.querySelector('.viper-sticky-image img');
                    if (!img) return;
                    
                    const rect = wrapper.getBoundingClientRect();
                    
                    // Apply parallax if section is hitting top of viewport
                    if (rect.top <= 0 && rect.bottom >= 0) {
                        const parallaxMove = Math.abs(rect.top) * 0.25; 
                        img.style.transform = `scale(1.1) translateY(${parallaxMove}px)`;
                    } else {
                        img.style.transform = `scale(1.1) translateY(0px)`;
                    }
                });
            });
        }, { passive: true });
    }

    // ========== Initialize All ==========
    function init() {
        try {
            initStickyHeader();
            initScrollAnimations();
            initHeroParticles();
            initCounters();
            initImageErrorHandling();
            initCutRevealParallax(); // Initialized new effect
        } catch (e) {
            console.error('Animation init error:', e);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();