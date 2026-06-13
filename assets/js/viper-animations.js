/**
 * Viper Template — Pixel-Perfect Animations
 * customstreetwear.co
 */
(function () {
  'use strict';

  /* ================================================
     1. CURSOR FOLLOWER
  ================================================ */
  var cursor = document.createElement('div');
  cursor.className = 'vp-cursor';
  var cursorDot = document.createElement('div');
  cursorDot.className = 'vp-cursor-dot';
  document.body.appendChild(cursor);
  document.body.appendChild(cursorDot);

  var mx = 0, my = 0, cx = 0, cy = 0;
  document.addEventListener('mousemove', function (e) {
    mx = e.clientX; my = e.clientY;
    cursorDot.style.transform = 'translate(' + (mx - 4) + 'px,' + (my - 4) + 'px)';
  });
  (function animCursor() {
    cx += (mx - cx) * 0.12;
    cy += (my - cy) * 0.12;
    cursor.style.transform = 'translate(' + (cx - 20) + 'px,' + (cy - 20) + 'px)';
    requestAnimationFrame(animCursor);
  })();

  document.querySelectorAll('a,button,.portfolio-card,.category-card,.service-card,.bento-card').forEach(function (el) {
    el.addEventListener('mouseenter', function () { cursor.classList.add('vp-cursor--hover'); });
    el.addEventListener('mouseleave', function () { cursor.classList.remove('vp-cursor--hover'); });
  });

  /* ================================================
     2. PAGE LOAD — CURTAIN REVEAL
  ================================================ */
  var curtain = document.createElement('div');
  curtain.className = 'vp-curtain';
  document.body.appendChild(curtain);
  window.addEventListener('load', function () {
    setTimeout(function () { curtain.classList.add('vp-curtain--out'); }, 100);
    setTimeout(function () { curtain.remove(); }, 1100);
  });

  /* ================================================
     3. SCROLL REVEAL — STAGGERED (Viper style)
  ================================================ */
  var animEls = document.querySelectorAll('[data-animate]');
  // Hero section — show immediately
  document.querySelectorAll('.hero-section [data-animate], .page-heading-section [data-animate]').forEach(function (el) {
    el.classList.add('visible');
  });

  if ('IntersectionObserver' in window && animEls.length) {
    var revealObs = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var el = entry.target;
          var delay = parseInt(el.dataset.delay || 0);
          setTimeout(function () { el.classList.add('visible'); }, delay);
          revealObs.unobserve(el);
        }
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    animEls.forEach(function (el) {
      if (!el.closest('.hero-section') && !el.closest('.page-heading-section')) {
        revealObs.observe(el);
      }
    });
  } else {
    animEls.forEach(function (el) { el.classList.add('visible'); });
  }

  /* stagger-children */
  document.querySelectorAll('.stagger-children').forEach(function (parent) {
    var children = parent.children;
    Array.prototype.forEach.call(children, function (child, i) {
      child.style.transitionDelay = (i * 80) + 'ms';
    });
  });

  /* ================================================
     4. STICKY HERO — sections scroll OVER pinned hero
  ================================================ */
  var stickyHero   = document.querySelector('.viper-sticky-section');
  var heroBgImg    = document.querySelector('.viper-hero__img');
  var heroContent  = document.querySelector('.viper-hero__content');
  var heroInlineImg = document.querySelector('.hero-image-wrap img');

  if (stickyHero) {
    window.addEventListener('scroll', function () {
      var sy   = window.scrollY;
      var vh   = window.innerHeight;
      var prog = Math.min(sy / vh, 1);
      if (heroBgImg) {
        heroBgImg.style.transform = 'scale(' + (1 + prog * 0.08) + ') translateY(' + (prog * 6) + '%)';
      }
      if (heroContent) {
        heroContent.style.opacity  = Math.max(1 - prog * 2, 0);
        heroContent.style.transform = 'translateY(' + (-prog * 40) + 'px)';
      }
    }, { passive: true });
  }

  if (heroInlineImg) {
    window.addEventListener('scroll', function () {
      var sy = window.scrollY;
      if (sy < window.innerHeight) {
        heroInlineImg.style.transform = 'translateY(' + (sy * 0.1) + 'px) scale(1.02)';
      }
    }, { passive: true });
  }

  /* ================================================
     5. TEXT SPLIT — WORD BY WORD FADE
  ================================================ */
  function splitWords(selector) {
    document.querySelectorAll(selector).forEach(function (el) {
      if (el.dataset.split) return;
      el.dataset.split = '1';
      var words = el.innerText.trim().split(/\s+/);
      el.innerHTML = words.map(function (w, i) {
        return '<span class="vp-word" style="transition-delay:' + (i * 60) + 'ms">' + w + '</span>';
      }).join(' ');
      el.classList.add('vp-split-ready');

      if ('IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function (entries) {
          if (entries[0].isIntersecting) {
            el.classList.add('vp-split-visible');
            obs.disconnect();
          }
        }, { threshold: 0.2 });
        obs.observe(el);
      } else {
        el.classList.add('vp-split-visible');
      }
    });
  }
  splitWords('.h2, .h3, .page-main-heading');

  /* ================================================
     6. SECTION LABEL — TYPEWRITER EFFECT
  ================================================ */
  if ('IntersectionObserver' in window) {
    var typeObs = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var el = entry.target;
        if (el.dataset.typed) return;
        el.dataset.typed = '1';
        var text = el.textContent;
        el.textContent = '';
        el.style.opacity = '1';
        var i = 0;
        var timer = setInterval(function () {
          el.textContent += text[i];
          i++;
          if (i >= text.length) clearInterval(timer);
        }, 40);
        typeObs.unobserve(el);
      });
    }, { threshold: 0.5 });
    document.querySelectorAll('.section-label').forEach(function (el) {
      typeObs.observe(el);
    });
  }

  /* ================================================
     7. MARQUEE / TICKER
  ================================================ */
  function initMarquee(trackSel, speed) {
    document.querySelectorAll(trackSel).forEach(function (track) {
      if (track.dataset.marquee) return;
      track.dataset.marquee = '1';
      var clone = track.cloneNode(true);
      track.parentNode.appendChild(clone);
      var pos = 0;
      var isReverse = track.classList.contains('reverse');
      var paused = false;
      track.parentNode.addEventListener('mouseenter', function () { paused = true; });
      track.parentNode.addEventListener('mouseleave', function () { paused = false; });
      (function tick() {
        if (!paused) {
          pos += isReverse ? speed : -speed;
          var w = track.scrollWidth;
          if (Math.abs(pos) >= w) pos = 0;
          var val = 'translateX(' + pos + 'px)';
          track.style.transform = val;
          clone.style.transform = 'translateX(' + (pos + (isReverse ? -w : w)) + 'px)';
        }
        requestAnimationFrame(tick);
      })();
    });
  }
  initMarquee('.logo-track', 0.5);
  initMarquee('.services-marquee-track', 0.6);

  /* ================================================
     8. PORTFOLIO CARDS — TILT 3D ON HOVER
  ================================================ */
  document.querySelectorAll('.portfolio-card, .category-card').forEach(function (card) {
    card.addEventListener('mousemove', function (e) {
      var r = card.getBoundingClientRect();
      var x = (e.clientX - r.left) / r.width - 0.5;
      var y = (e.clientY - r.top) / r.height - 0.5;
      card.style.transform = 'perspective(600px) rotateY(' + (x * 10) + 'deg) rotateX(' + (-y * 10) + 'deg) scale(1.03)';
    });
    card.addEventListener('mouseleave', function () {
      card.style.transform = '';
    });
  });

  /* ================================================
     9. BENTO CARDS — MAGNETIC HOVER
  ================================================ */
  document.querySelectorAll('.bento-card').forEach(function (card) {
    card.addEventListener('mousemove', function (e) {
      var r = card.getBoundingClientRect();
      var x = (e.clientX - r.left - r.width / 2) * 0.04;
      var y = (e.clientY - r.top - r.height / 2) * 0.04;
      card.style.transform = 'translate(' + x + 'px,' + y + 'px)';
      card.style.boxShadow = '0 20px 60px rgba(0,0,0,0.4)';
    });
    card.addEventListener('mouseleave', function () {
      card.style.transform = '';
      card.style.boxShadow = '';
    });
  });

  /* ================================================
     10. STAT COUNTERS
  ================================================ */
  if ('IntersectionObserver' in window) {
    var countObs = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var el = entry.target;
        var target = parseInt(el.dataset.counter || el.textContent, 10);
        if (isNaN(target)) return;
        var suffix = el.textContent.includes('%') ? '%' : '+';
        var start = 0, dur = 2000, t0 = null;
        function step(ts) {
          if (!t0) t0 = ts;
          var p = Math.min((ts - t0) / dur, 1);
          var eased = 1 - Math.pow(1 - p, 4);
          el.textContent = Math.floor(eased * target) + suffix;
          if (p < 1) requestAnimationFrame(step);
          else el.textContent = target + suffix;
        }
        requestAnimationFrame(step);
        countObs.unobserve(el);
      });
    }, { threshold: 0.4 });
    document.querySelectorAll('.stat-number, [data-counter]').forEach(function (el) {
      countObs.observe(el);
    });
  }

  /* ================================================
     11. PROGRESS BARS
  ================================================ */
  if ('IntersectionObserver' in window) {
    var progObs = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var fill = entry.target;
        var w = fill.dataset.width || '0';
        setTimeout(function () { fill.style.width = w + '%'; }, 300);
        progObs.unobserve(fill);
      });
    }, { threshold: 0.3 });
    document.querySelectorAll('.progress-fill').forEach(function (el) { progObs.observe(el); });
  }

  /* ================================================
     12. TESTIMONIALS SCROLL
  ================================================ */
  var tScroll = document.querySelector('.testimonials-scroll');
  if (tScroll) {
    var isDown = false, startX, scrollLeft;
    tScroll.addEventListener('mousedown', function (e) {
      isDown = true; startX = e.pageX - tScroll.offsetLeft; scrollLeft = tScroll.scrollLeft;
      tScroll.style.cursor = 'grabbing';
    });
    tScroll.addEventListener('mouseleave', function () { isDown = false; tScroll.style.cursor = 'grab'; });
    tScroll.addEventListener('mouseup', function () { isDown = false; tScroll.style.cursor = 'grab'; });
    tScroll.addEventListener('mousemove', function (e) {
      if (!isDown) return;
      e.preventDefault();
      var x = e.pageX - tScroll.offsetLeft;
      tScroll.scrollLeft = scrollLeft - (x - startX) * 1.5;
    });
    tScroll.style.cursor = 'grab';

    var autoPaused = false;
    tScroll.addEventListener('mouseenter', function () { autoPaused = true; });
    tScroll.addEventListener('mouseleave', function () { autoPaused = false; });
    setInterval(function () {
      if (autoPaused) return;
      var max = tScroll.scrollWidth - tScroll.clientWidth;
      if (tScroll.scrollLeft >= max - 10) {
        tScroll.scrollTo({ left: 0, behavior: 'smooth' });
      } else {
        tScroll.scrollBy({ left: 380, behavior: 'smooth' });
      }
    }, 3500);
  }

  /* ================================================
     13. GALLERY LIGHTBOX
  ================================================ */
  document.querySelectorAll('.gallery-item img').forEach(function (img) {
    img.style.transition = 'transform 0.5s cubic-bezier(0.25,0.46,0.45,0.94)';
    img.parentElement.addEventListener('mouseenter', function () {
      img.style.transform = 'scale(1.08)';
    });
    img.parentElement.addEventListener('mouseleave', function () {
      img.style.transform = 'scale(1)';
    });
    img.parentElement.addEventListener('click', function () {
      var lb = document.createElement('div');
      lb.className = 'vp-lightbox';
      lb.innerHTML = '<div class="vp-lightbox-inner"><img src="' + img.src + '"><button class="vp-lightbox-close">&times;</button></div>';
      document.body.appendChild(lb);
      requestAnimationFrame(function () { lb.classList.add('vp-lightbox--in'); });
      lb.addEventListener('click', function (e) {
        if (e.target === lb || e.target.classList.contains('vp-lightbox-close')) {
          lb.classList.remove('vp-lightbox--in');
          setTimeout(function () { lb.remove(); }, 400);
        }
      });
    });
  });

  /* ================================================
     14. PROCESS STEPS
  ================================================ */
  var steps = document.querySelectorAll('.process-step');
  steps.forEach(function (step, i) {
    if (i === 0) step.classList.add('active');
    step.addEventListener('click', function () {
      steps.forEach(function (s) { s.classList.remove('active'); });
      step.classList.add('active');
    });
  });

  /* ================================================
     15. FLOATING PRODUCT IMAGES
  ================================================ */
  document.querySelectorAll('.hero-floating-item').forEach(function (item, i) {
    var delay = i * 600;
    var amp = 8 + i * 3;
    var dur = 3000 + i * 500;
    var t0 = null;
    (function float(ts) {
      if (!t0) t0 = ts;
      var elapsed = ts - t0 + delay;
      var y = Math.sin(elapsed / dur * Math.PI * 2) * amp;
      item.style.transform = 'translateY(' + y + 'px)';
      requestAnimationFrame(float);
    })(0);
  });

  /* ================================================
     16. HEADER BLUR ON SCROLL
  ================================================ */
  var hdr = document.querySelector('.site-header');
  if (hdr) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 60) {
        hdr.style.backdropFilter = 'blur(20px) saturate(180%)';
        hdr.style.borderBottomColor = 'var(--border)';
      } else {
        hdr.style.backdropFilter = 'blur(0px)';
        hdr.style.borderBottomColor = 'transparent';
      }
    }, { passive: true });
  }

  /* ================================================
     17. SECTION NUMBERS
  ================================================ */
  if ('IntersectionObserver' in window) {
    var numObs = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('vp-num-flip');
          numObs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });
    document.querySelectorAll('.section-counter, .process-step-number').forEach(function (el) {
      numObs.observe(el);
    });
  }

  /* ================================================
     18. SMOOTH PAGE TRANSITIONS
  ================================================ */
  document.querySelectorAll('a[href]:not([href^="#"]):not([href^="mailto"]):not([href^="tel"]):not([target])').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var href = a.getAttribute('href');
      if (!href || href.startsWith('http') || href.startsWith('//')) return;
      e.preventDefault();
      var out = document.createElement('div');
      out.className = 'vp-curtain vp-curtain--in';
      document.body.appendChild(out);
      setTimeout(function () { window.location = href; }, 500);
    });
  });

})();

/* ================================================
   19. HERO FLOATING PRODUCT SLIDER
================================================ */
(function () {
  var track = document.getElementById('heroFloatingTrack');
  if (!track) return;
  var items = track.querySelectorAll('.hero-floating-item');
  var countEl = document.getElementById('heroSliderCount');
  var prevBtn = document.getElementById('heroSliderPrev');
  var nextBtn = document.getElementById('heroSliderNext');
  if (items.length < 2) return;
  var current = 0;
  var total = items.length;
  var autoTimer;

  function goTo(n) {
    items[current].classList.remove('active');
    current = (n + total) % total;
    items[current].classList.add('active');
    if (countEl) countEl.textContent = (current + 1) + ' / ' + total;
  }

  function startAuto() {
    autoTimer = setInterval(function () { goTo(current + 1); }, 3000);
  }
  function stopAuto() { clearInterval(autoTimer); }

  if (prevBtn) prevBtn.addEventListener('click', function () { stopAuto(); goTo(current - 1); startAuto(); });
  if (nextBtn) nextBtn.addEventListener('click', function () { stopAuto(); goTo(current + 1); startAuto(); });

  startAuto();
})();

/* ================================================
   20. GALLERY HORIZONTAL SCROLL
================================================ */
(function () {
  var track = document.getElementById('galleryScrollTrack');
  if (!track) return;
  var prevBtn = document.getElementById('galleryPrev');
  var nextBtn = document.getElementById('galleryNext');
  var scrollAmt = 340;

  if (prevBtn) prevBtn.addEventListener('click', function () {
    track.scrollBy({ left: -scrollAmt, behavior: 'smooth' });
  });
  if (nextBtn) nextBtn.addEventListener('click', function () {
    track.scrollBy({ left: scrollAmt, behavior: 'smooth' });
  });

  var isDown = false, startX, scrollLeft;
  track.addEventListener('mousedown', function (e) {
    isDown = true;
    startX = e.pageX - track.offsetLeft;
    scrollLeft = track.scrollLeft;
    track.style.cursor = 'grabbing';
  });
  track.addEventListener('mouseleave', function () { isDown = false; track.style.cursor = 'grab'; });
  track.addEventListener('mouseup', function () { isDown = false; track.style.cursor = 'grab'; });
  track.addEventListener('mousemove', function (e) {
    if (!isDown) return;
    e.preventDefault();
    var x = e.pageX - track.offsetLeft;
    track.scrollLeft = scrollLeft - (x - startX) * 1.4;
  });
})();

/* ================================================
   21-29. PREVIOUS ANIMATIONS AND OBSERVERS
================================================ */
(function viperHeroParallax() {
  var heroBg = document.querySelector('.viper-hero__bg');
  if (!heroBg) return;
  var hero = document.querySelector('.viper-hero');
  var ticking = false;
  window.addEventListener('scroll', function () {
    if (!ticking) {
      requestAnimationFrame(function () {
        var scrollY = window.scrollY;
        var heroHeight = hero ? hero.offsetHeight : window.innerHeight;
        var progress = Math.min(scrollY / heroHeight, 1);
        var scale = 1 + (progress * 0.15);
        heroBg.style.transform = 'scale(' + scale + ')';
        ticking = false;
      });
      ticking = true;
    }
  }, { passive: true });
})();

(function pageHeadingParallax() {
  var bgImg = document.querySelector('.page-heading-bg-img');
  if (!bgImg) return;
  window.addEventListener('scroll', function () {
    requestAnimationFrame(function () {
      var sy = window.scrollY;
      if (sy < window.innerHeight) {
        bgImg.style.transform = 'translateY(' + (sy * 0.3) + 'px) scale(1.1)';
      }
    });
  }, { passive: true });
})();

(function navScroll() {
  var nav = document.querySelector('.site-header');
  if (!nav) return;
  window.addEventListener('scroll', function () {
    nav.classList.toggle('scrolled', window.scrollY > 50);
  }, { passive: true });
})();

(function backToTop() {
  var btn = document.createElement('button');
  btn.className = 'viper-back-top';
  btn.textContent = '© Back to top';
  btn.setAttribute('aria-label', 'Back to top');
  document.body.appendChild(btn);
  window.addEventListener('scroll', function () {
    btn.classList.toggle('visible', window.scrollY > 400);
  }, { passive: true });
  btn.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
})();

(function viperStepReveal() {
  if (!('IntersectionObserver' in window)) return;
  var obs = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (!entry.isIntersecting) return;
      var el = entry.target;
      el.classList.add('visible');
      var fill = el.querySelector('.viper-progress-fill');
      if (fill) {
        setTimeout(function () { fill.style.width = (fill.dataset.width || '0') + '%'; }, 200);
      }
      obs.unobserve(el);
    });
  }, { threshold: 0.2 });
  document.querySelectorAll('.viper-step, .viper-progress-item').forEach(function (el) {
    obs.observe(el);
  });
})();

(function viperTestimonialReveal() {
  if (!('IntersectionObserver' in window)) return;
  var obs = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry, i) {
      if (!entry.isIntersecting) return;
      var el = entry.target;
      setTimeout(function () { el.classList.add('visible'); }, i * 100);
      obs.unobserve(el);
    });
  }, { threshold: 0.15 });
  document.querySelectorAll('.viper-testimonial-card').forEach(function (el) { obs.observe(el); });
})();

(function overlayStack() {
  var sections = document.querySelectorAll('.viper-over-section > section');
  if (!sections.length) return;
  sections.forEach(function (s, i) {
    s.style.zIndex = i + 1;
  });
})();

/* ================================================
   30. CUSTOM PIN & SPIN OVERLAP ANIMATION (Naya Code)
================================================ */
document.addEventListener("DOMContentLoaded", function() {
    const targetImages = document.querySelectorAll('.hero-image-wrap img, .portfolio-card-image, .bento-card img, .gallery-item img, .gallery-scroll-item img');

    window.addEventListener('scroll', function() {
        const screenCenter = window.innerHeight / 2;

        targetImages.forEach(function(img) {
            const parent = img.parentElement;
            if(!parent) return;
            const rect = parent.getBoundingClientRect();
            
            const parentCenter = rect.top + (rect.height / 2);
            let translateY = 0;
            let rotate = 0;

            if (parentCenter <= screenCenter) {
                // Pin image to the center of the screen
                translateY = screenCenter - parentCenter; 
                // Spin animation logic (speed 0.08)
                rotate = (screenCenter - parentCenter) * 0.08; 
            }

            // Apply smooth transform
            img.style.transform = 'translateY(' + translateY + 'px) rotate(' + rotate + 'deg)';
            img.style.transition = 'transform 0.1s ease-out';
            img.style.willChange = 'transform';
        });
    }, { passive: true });
});