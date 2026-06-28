/* ============================================
   HEALTHFLOWRCM - Main JavaScript
   ============================================ */

document.addEventListener('DOMContentLoaded', function() {

  /* Header Scroll Effect */
  const header = document.querySelector('.header');
  if (header) {
    window.addEventListener('scroll', function() {
      header.classList.toggle('scrolled', window.scrollY > 20);
    });
  }

  /* Mobile Menu */
  const menuToggle = document.querySelector('.menu-toggle');
  const navLinks = document.querySelector('.nav-links');
  const overlay = document.querySelector('.mobile-overlay');
  
  if (overlay) overlay.style.zIndex = '998';

  if (menuToggle && navLinks) {
    menuToggle.addEventListener('click', function() {
      menuToggle.classList.toggle('active');
      navLinks.classList.toggle('open');
      if (overlay) overlay.classList.toggle('active');
      document.body.style.overflow = navLinks.classList.contains('open') ? 'hidden' : '';
    });
    if (overlay) {
      overlay.addEventListener('click', function() {
        menuToggle.classList.remove('active');
        navLinks.classList.remove('open');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
      });
    }
    navLinks.querySelectorAll('a').forEach(function(link) {
      link.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
          // Delay closing the menu so mobile browsers have time to register the native link navigation
          setTimeout(function() {
            menuToggle.classList.remove('active');
            navLinks.classList.remove('open');
            if (overlay) overlay.classList.remove('active');
            document.body.style.overflow = '';
          }, 150);
        }
      });
    });
  }

  /* Scroll Animations */
  const animElements = document.querySelectorAll('.fade-in, .fade-in-left, .fade-in-right');
  if (animElements.length > 0) {
    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
    animElements.forEach(function(el) { observer.observe(el); });
  }

  /* Counter Animation */
  const counters = document.querySelectorAll('[data-count]');
  if (counters.length > 0) {
    const counterObserver = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          counterObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });
    counters.forEach(function(el) { counterObserver.observe(el); });
  }

  function animateCounter(el) {
    var target = parseInt(el.getAttribute('data-count'));
    var suffix = el.getAttribute('data-suffix') || '';
    var prefix = el.getAttribute('data-prefix') || '';
    var duration = 2000;
    var start = 0;
    var startTime = null;

    function update(timestamp) {
      if (!startTime) startTime = timestamp;
      var progress = Math.min((timestamp - startTime) / duration, 1);
      var eased = 1 - Math.pow(1 - progress, 4);
      var current = Math.floor(eased * target);
      el.textContent = prefix + current.toLocaleString() + suffix;
      if (progress < 1) requestAnimationFrame(update);
    }
    requestAnimationFrame(update);
  }

  /* Active Nav Link */
  var currentPage = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-links a:not(.nav-cta)').forEach(function(link) {
    var href = link.getAttribute('href');
    if (href === currentPage || (currentPage === '' && href === 'index.html')) {
      link.classList.add('active');
    }
  });

  /* Testimonial Slider */
  var slider = document.querySelector('.testimonial-slider');
  if (slider) {
    var cards = slider.querySelectorAll('.testimonial-card');
    var dots = document.querySelectorAll('.slider-dot');
    var currentSlide = 0;
    var totalSlides = cards.length;
    var autoSlide;

    function goToSlide(index) {
      currentSlide = index;
      slider.style.transform = 'translateX(-' + (index * 100) + '%)';
      dots.forEach(function(dot, i) {
        dot.classList.toggle('active', i === index);
      });
    }

    dots.forEach(function(dot, i) {
      dot.addEventListener('click', function() {
        goToSlide(i);
        clearInterval(autoSlide);
        startAutoSlide();
      });
    });

    function startAutoSlide() {
      autoSlide = setInterval(function() {
        goToSlide((currentSlide + 1) % totalSlides);
      }, 5000);
    }
    startAutoSlide();
  }

  /* Form Submission */
  var consultForm = document.getElementById('consultancy-form');
  if (consultForm) {
    consultForm.addEventListener('submit', function(e) {
      e.preventDefault();
      var btn = consultForm.querySelector('.btn-submit');
      var originalText = btn.innerHTML;
      btn.innerHTML = '<span class="spinner"></span> Sending...';
      btn.disabled = true;

      setTimeout(function() {
        btn.innerHTML = '&#10003; Request Submitted!';
        btn.style.background = '#22c55e';
        consultForm.reset();
        setTimeout(function() {
          btn.innerHTML = originalText;
          btn.style.background = '';
          btn.disabled = false;
        }, 3000);
      }, 1500);
    });
  }

  /* Smooth scroll for anchor links */
  document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
      var targetId = this.getAttribute('href');
      if (targetId === '#') return;
      var target = document.querySelector(targetId);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

});
