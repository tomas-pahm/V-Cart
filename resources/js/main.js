/**
* Template Name: EasyFolio
* Template URL: https://bootstrapmade.com/easyfolio-bootstrap-portfolio-template/
* Updated: Feb 21 2025 with Bootstrap v5.3.3
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

(function() {
  "use strict";

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   */
  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  /**
   * Mobile nav toggle
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavToggleBtn.classList.toggle('bi-list');
    mobileNavToggleBtn.classList.toggle('bi-x');
  }
  if (mobileNavToggleBtn) {
    mobileNavToggleBtn.addEventListener('click', mobileNavToogle);
  }

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navmenu a').forEach(navmenu => {
    navmenu.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });

  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

  /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

  /**
   * Animate the skills items on reveal
   */
  let skillsAnimation = document.querySelectorAll('.skills-animation');
  skillsAnimation.forEach((item) => {
    new Waypoint({
      element: item,
      offset: '80%',
      handler: function(direction) {
        let progress = item.querySelectorAll('.progress .progress-bar');
        progress.forEach(el => {
          el.style.width = el.getAttribute('aria-valuenow') + '%';
        });
      }
    });
  });

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Init isotope layout and filters
   */
  document.querySelectorAll('.isotope-layout').forEach(function(isotopeItem) {
    let layout = isotopeItem.getAttribute('data-layout') ?? 'masonry';
    let filter = isotopeItem.getAttribute('data-default-filter') ?? '*';
    let sort = isotopeItem.getAttribute('data-sort') ?? 'original-order';

    let initIsotope;
    imagesLoaded(isotopeItem.querySelector('.isotope-container'), function() {
      initIsotope = new Isotope(isotopeItem.querySelector('.isotope-container'), {
        itemSelector: '.isotope-item',
        layoutMode: layout,
        filter: filter,
        sortBy: sort
      });
    });

    isotopeItem.querySelectorAll('.isotope-filters li').forEach(function(filters) {
      filters.addEventListener('click', function() {
        isotopeItem.querySelector('.isotope-filters .filter-active').classList.remove('filter-active');
        this.classList.add('filter-active');
        initIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        if (typeof aosInit === 'function') {
          aosInit();
        }
      }, false);
    });

  });

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Frequently Asked Questions Toggle
   */
  document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle').forEach((faqItem) => {
    faqItem.addEventListener('click', () => {
      faqItem.parentNode.classList.toggle('faq-active');
    });
  });

  /**
   * Correct scrolling position upon page load for URLs containing hash links.
   */
  window.addEventListener('load', function(e) {
    if (window.location.hash) {
      if (document.querySelector(window.location.hash)) {
        setTimeout(() => {
          let section = document.querySelector(window.location.hash);
          let scrollMarginTop = getComputedStyle(section).scrollMarginTop;
          window.scrollTo({
            top: section.offsetTop - parseInt(scrollMarginTop),
            behavior: 'smooth'
          });
        }, 100);
      }
    }
  });

  /**
   * Navmenu Scrollspy
   */
  let navmenulinks = document.querySelectorAll('.navmenu a');

  function navmenuScrollspy() {
    navmenulinks.forEach(navmenulink => {
      if (!navmenulink.hash) return;
      let section = document.querySelector(navmenulink.hash);
      if (!section) return;
      let position = window.scrollY + 200;
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        document.querySelectorAll('.navmenu a.active').forEach(link => link.classList.remove('active'));
        navmenulink.classList.add('active');
      } else {
        navmenulink.classList.remove('active');
      }
    })
  }
  window.addEventListener('load', navmenuScrollspy);
  document.addEventListener('scroll', navmenuScrollspy);

})();

document.getElementById("anonymousForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const textarea = this.querySelector("textarea");
    const content = textarea.value.trim();
    if (!content) return;

    const post = document.createElement("div");
    post.className = "col";
    post.innerHTML = `
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <p class="card-text">${content}</p>
        </div>
      </div>`;

    document.getElementById("anonymousPosts").prepend(post);
    textarea.value = "";
  });


  // Lưu và hiển thị mục tiêu cá nhân
  const goalForm = document.getElementById('goalForm');
  const goalInput = document.getElementById('goalInput');
  const currentGoal = document.getElementById('currentGoal');

  goalForm.addEventListener('submit', function(e) {
    e.preventDefault();
    if (goalInput.value.trim()) {
      localStorage.setItem('healingGoal', goalInput.value.trim());
      currentGoal.textContent = 'Mục tiêu hiện tại: ' + goalInput.value.trim();
      goalInput.value = '';
    }
  });

  // Hiển thị mục tiêu nếu đã lưu
  const savedGoal = localStorage.getItem('healingGoal');
  if (savedGoal) {
    currentGoal.textContent = 'Mục tiêu hiện tại: ' + savedGoal;
  }

  // Lưu nhật ký hàng ngày
  const journalForm = document.getElementById('journalForm');
  const journalEntry = document.getElementById('journalEntry');
  const moodSelect = document.getElementById('moodSelect');
  const journalList = document.getElementById('journalList');

  journalForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const entryText = journalEntry.value.trim();
    const mood = moodSelect.value;
    if (entryText) {
      const date = new Date().toLocaleDateString();
      const journalItem = document.createElement('div');
      journalItem.className = 'list-group-item';
      journalItem.innerHTML = `
        <strong>${date} - Cảm xúc: ${mood}</strong>
        <p>${entryText}</p>
      `;
      journalList.prepend(journalItem);
      journalEntry.value = '';
      moodSelect.value = 'Vui';
      // Lưu vào localStorage (lưu nhật ký theo mảng)
      let storedEntries = JSON.parse(localStorage.getItem('journalEntries') || '[]');
      storedEntries.unshift({ date, mood, entry: entryText });
      localStorage.setItem('journalEntries', JSON.stringify(storedEntries));
    }
  });

  // Hiển thị các nhật ký đã lưu khi tải trang
  window.addEventListener('load', () => {
    let storedEntries = JSON.parse(localStorage.getItem('journalEntries') || '[]');
    storedEntries.forEach(({date, mood, entry}) => {
      const journalItem = document.createElement('div');
      journalItem.className = 'list-group-item';
      journalItem.innerHTML = `
        <strong>${date} - Cảm xúc: ${mood}</strong>
        <p>${entry}</p>
      `;
      journalList.appendChild(journalItem);
    });
  });

  document.addEventListener("DOMContentLoaded", () => {
      const cards = document.querySelectorAll(".deconstructed-card");

      cards.forEach((card) => {
        card.addEventListener("mousemove", (e) => {
          const rect = card.getBoundingClientRect();
          const x = (e.clientX - rect.left) / rect.width;
          const y = (e.clientY - rect.top) / rect.height;
          const xDeg = (y - 0.5) * 8;
          const yDeg = (x - 0.5) * -8;
          card.style.transform = `perspective(1200px) rotateX(${xDeg}deg) rotateY(${yDeg}deg)`;

          const layers = card.querySelectorAll(".card-layer");
          layers.forEach((layer, index) => {
            const depth = 30 * (index + 1);
            const offsetX = (x - 0.5) * 10 * (index + 1);
            const offsetY = (y - 0.5) * 10 * (index + 1);
            layer.style.transform = `translate3d(${offsetX}px, ${offsetY}px, ${depth}px)`;
          });
        });

        card.addEventListener("mouseleave", () => {
          card.style.transform = "";
          const layers = card.querySelectorAll(".card-layer");
          layers.forEach((layer) => {
            layer.style.transform = "";
          });
        });
      });
    });

    document.addEventListener("DOMContentLoaded", () => {
      const cards = document.querySelectorAll(".deconstructed-card");

      cards.forEach((card) => {
        card.addEventListener("mousemove", (e) => {
          const rect = card.getBoundingClientRect();
          const x = (e.clientX - rect.left) / rect.width;
          const y = (e.clientY - rect.top) / rect.height;
          const xDeg = (y - 0.5) * 8;
          const yDeg = (x - 0.5) * -8;
          card.style.transform = `perspective(1200px) rotateX(${xDeg}deg) rotateY(${yDeg}deg)`;

          const layers = card.querySelectorAll(".card-layer");
          layers.forEach((layer, index) => {
            const depth = 30 * (index + 1);
            const offsetX = (x - 0.5) * 10 * (index + 1);
            const offsetY = (y - 0.5) * 10 * (index + 1);
            layer.style.transform = `translate3d(${offsetX}px, ${offsetY}px, ${depth}px)`;
          });
        });

        card.addEventListener("mouseleave", () => {
          card.style.transform = "";
          const layers = card.querySelectorAll(".card-layer");
          layers.forEach((layer) => {
            layer.style.transform = "";
          });
        });
      });
    });


    document.addEventListener("DOMContentLoaded", () => {
      const cards = document.querySelectorAll(".deconstructed-card");

      cards.forEach((card) => {
        card.addEventListener("mousemove", (e) => {
          const rect = card.getBoundingClientRect();
          const x = (e.clientX - rect.left) / rect.width;
          const y = (e.clientY - rect.top) / rect.height;
          const xDeg = (y - 0.5) * 8;
          const yDeg = (x - 0.5) * -8;
          card.style.transform = `perspective(1200px) rotateX(${xDeg}deg) rotateY(${yDeg}deg)`;

          const layers = card.querySelectorAll(".card-layer");
          layers.forEach((layer, index) => {
            const depth = 30 * (index + 1);
            const offsetX = (x - 0.5) * 10 * (index + 1);
            const offsetY = (y - 0.5) * 10 * (index + 1);
            layer.style.transform = `translate3d(${offsetX}px, ${offsetY}px, ${depth}px)`;
          });
        });

        card.addEventListener("mouseleave", () => {
          card.style.transform = "";
          const layers = card.querySelectorAll(".card-layer");
          layers.forEach((layer) => {
            layer.style.transform = "";
          });
        });
      });
    });
