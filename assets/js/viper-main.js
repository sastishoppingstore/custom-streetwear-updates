(function() {
  'use strict';

  /* ============= THEME TOGGLE ============= */
  const themeToggles = document.querySelectorAll('[data-theme-toggle]');
  const root = document.documentElement;

  function setTheme(theme) {
    root.setAttribute('data-theme', theme);
    localStorage.setItem('csw-theme', theme);
    themeToggles.forEach(function(toggle) {
      toggle.setAttribute('aria-pressed', theme === 'light' ? 'true' : 'false');
      const label = toggle.querySelector('.theme-toggle-label');
      if (label) label.textContent = theme === 'light' ? 'Day Mode' : 'Night Mode';
    });
  }

  if (themeToggles.length > 0) {
    const currentTheme = root.getAttribute('data-theme') || 'dark';
    setTheme(currentTheme);
    themeToggles.forEach(function(toggle) {
      toggle.addEventListener('click', function() {
        const nextTheme = root.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
        setTheme(nextTheme);
      });
    });
  }

  /* ============= STICKY HEADER ============= */
  const header = document.querySelector('.site-header');
  let lastScroll = 0;

  if (header) {
    window.addEventListener('scroll', function() {
      const scrollY = window.scrollY;
      if (scrollY > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
      lastScroll = scrollY;
    }, { passive: true });
  }

  /* ============= MOBILE MENU ============= */
  const menuToggle = document.querySelector('.menu-toggle');
  const mobileDrawer = document.querySelector('.mobile-drawer');

  if (menuToggle && mobileDrawer) {
    menuToggle.addEventListener('click', function() {
      this.classList.toggle('active');
      mobileDrawer.classList.toggle('active');
      document.body.style.overflow = mobileDrawer.classList.contains('active') ? 'hidden' : '';
    });
  }

  /* ============= SCROLL REVEAL (IntersectionObserver) ============= */
  const revealElements = document.querySelectorAll('[data-animate], .reveal, .reveal-left, .reveal-right, .reveal-scale, .stagger-children');

  if (revealElements.length > 0) {
    const revealObserver = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          revealObserver.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    });

    revealElements.forEach(function(el) {
      if (el.dataset.delay) {
        el.style.transitionDelay = el.dataset.delay + 'ms';
      }
      revealObserver.observe(el);
    });
  }

  /* ============= ANIMATED COUNTERS ============= */
  const counters = document.querySelectorAll('[data-counter]');

  if (counters.length > 0) {
    const counterObserver = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          const el = entry.target;
          const target = parseInt(el.dataset.counter, 10);
          const duration = 2000;
          const startTime = performance.now();

          function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = Math.floor(eased * target);

            el.textContent = current + '+';
            el.classList.add('counted');

            if (progress < 1) {
              requestAnimationFrame(updateCounter);
            } else {
              el.textContent = target.toLocaleString() + '+';
            }
          }

          requestAnimationFrame(updateCounter);
          counterObserver.unobserve(el);
        }
      });
    }, { threshold: 0.3 });

    counters.forEach(function(counter) {
      counterObserver.observe(counter);
    });
  }

  /* ============= PROCESS ACCORDION ============= */
  const processSteps = document.querySelectorAll('.process-step');

  if (processSteps.length > 0) {
    processSteps.forEach(function(step) {
      step.addEventListener('click', function() {
        this.classList.toggle('active');
      });
    });

    // Open first by default
    processSteps[0].classList.add('active');
  }

  /* ============= FAQ ACCORDION ============= */
  const faqItems = document.querySelectorAll('.faq-item');

  if (faqItems.length > 0) {
    faqItems.forEach(function(item) {
      const question = item.querySelector('.faq-question');
      if (question) {
        question.addEventListener('click', function() {
          const isActive = item.classList.contains('active');

          // Close all others
          faqItems.forEach(function(other) {
            other.classList.remove('active');
          });

          // Toggle current
          if (!isActive) {
            item.classList.add('active');
          }
        });
      }
    });
  }

  /* ============= SMOOTH ANCHOR SCROLL ============= */
  document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
      const href = this.getAttribute('href');
      if (href === '#') return;
      const target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        const headerOffset = 80;
        const elementPosition = target.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
        window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
      }
    });
  });

  /* ============= MAGNETIC BUTTON EFFECT ============= */
  const magneticBtns = document.querySelectorAll('.magnetic-btn');

  magneticBtns.forEach(function(btn) {
    btn.addEventListener('mousemove', function(e) {
      const rect = this.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;
      this.style.transform = 'translate(' + x * 0.3 + 'px, ' + y * 0.3 + 'px)';
    });

    btn.addEventListener('mouseleave', function() {
      this.style.transform = 'translate(0, 0)';
    });
  });

  /* ============= BACK TO TOP ============= */
  const backToTop = document.querySelector('.back-to-top');

  if (backToTop) {
    backToTop.addEventListener('click', function() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ============= PROGRESS BAR ANIMATION ============= */
  const progressFills = document.querySelectorAll('.progress-fill');

  if (progressFills.length > 0) {
    const progressObserver = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          const fill = entry.target;
          const width = fill.dataset.width || fill.textContent || '0';
          setTimeout(function() {
            fill.style.width = width + '%';
          }, 200);
          progressObserver.unobserve(fill);
        }
      });
    }, { threshold: 0.3 });

    progressFills.forEach(function(fill) {
      progressObserver.observe(fill);
    });
  }

  /* ============= TESTIMONIAL SCROLL (Manual Only) ============= */
  const testimonialScroll = document.querySelector('.testimonials-scroll');

  if (testimonialScroll) {
    function stopAutoScroll() {
      // Auto-scroll disabled - manual scroll only
    }

    stopAutoScroll();
  }

  /* ============= QUOTE MODAL ============= */
  window.openQuoteModal = function() {
    const overlay = document.getElementById('quoteModalOverlay');
    const modal = document.getElementById('quoteModal');
    if (overlay) overlay.classList.add('active');
    if (modal) modal.classList.add('active');
    document.body.style.overflow = 'hidden';
  };

  window.closeQuoteModal = function() {
    const overlay = document.getElementById('quoteModalOverlay');
    const modal = document.getElementById('quoteModal');
    if (overlay) overlay.classList.remove('active');
    if (modal) modal.classList.remove('active');
    document.body.style.overflow = '';
  };

  window.submitQuoteForm = function(e) {
    const btn = document.getElementById('quoteSubmitBtn');
    const btnText = btn ? btn.querySelector('.btn-text') : null;
    const btnLoader = btn ? btn.querySelector('.btn-loader') : null;
    if (btnText) btnText.style.display = 'none';
    if (btnLoader) btnLoader.style.display = 'inline-flex';
    return true;
  };

})();
