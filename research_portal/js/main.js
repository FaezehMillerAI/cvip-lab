/**
 * ==========================================================================
 * CVIP LAB - INTERACTIVE JAVASCRIPT & NEURAL VISION ANIMATION
 * Computer Vision & Image Processing Research Laboratory
 * ==========================================================================
 */

document.addEventListener('DOMContentLoaded', () => {
  initTheme();
  initVisionCanvas();
  initMobileNav();
  initStudentFilters();
  initPublicationSearch();
  initModals();
});

/* ==========================================================================
   Theme Switcher (Dark / Light)
   ========================================================================== */
function initTheme() {
  const themeToggles = document.querySelectorAll('.theme-toggle');
  const savedTheme = localStorage.getItem('cvip_theme') || 'dark';

  document.documentElement.setAttribute('data-theme', savedTheme);
  updateThemeIcons(savedTheme);

  themeToggles.forEach(btn => {
    btn.addEventListener('click', () => {
      const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
      const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', newTheme);
      localStorage.setItem('cvip_theme', newTheme);
      updateThemeIcons(newTheme);
    });
  });
}

function updateThemeIcons(theme) {
  const themeIcons = document.querySelectorAll('.theme-toggle');
  themeIcons.forEach(btn => {
    btn.innerHTML = theme === 'dark' 
      ? '☀️' 
      : '🌙';
    btn.setAttribute('title', theme === 'dark' ? 'Switch to Light Mode' : 'Switch to Dark Mode');
  });
}

/* ==========================================================================
   Interactive Neural Vision Canvas
   ========================================================================== */
function initVisionCanvas() {
  const canvas = document.getElementById('vision-canvas');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  let width, height;
  let particles = [];
  let mouse = { x: null, y: null, radius: 140 };

  function resize() {
    width = canvas.width = canvas.offsetWidth;
    height = canvas.height = canvas.offsetHeight;
  }

  window.addEventListener('resize', resize);
  resize();

  window.addEventListener('mousemove', (e) => {
    const rect = canvas.getBoundingClientRect();
    mouse.x = e.clientX - rect.left;
    mouse.y = e.clientY - rect.top;
  });

  window.addEventListener('mouseleave', () => {
    mouse.x = null;
    mouse.y = null;
  });

  const particleCount = Math.min(Math.floor((width * height) / 12000), 75);

  class Particle {
    constructor() {
      this.x = Math.random() * width;
      this.y = Math.random() * height;
      this.vx = (Math.random() - 0.5) * 0.9;
      this.vy = (Math.random() - 0.5) * 0.9;
      this.radius = Math.random() * 2.2 + 1.2;
      this.color = Math.random() > 0.4 ? '#38bdf8' : '#818cf8';
      this.isBoundingBox = Math.random() > 0.88;
      this.boxSize = Math.random() * 24 + 16;
    }

    update() {
      this.x += this.vx;
      this.y += this.vy;

      if (this.x < 0 || this.x > width) this.vx *= -1;
      if (this.y < 0 || this.y > height) this.vy *= -1;

      // Mouse interactivity
      if (mouse.x !== null) {
        const dx = mouse.x - this.x;
        const dy = mouse.y - this.y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < mouse.radius) {
          const force = (mouse.radius - dist) / mouse.radius;
          this.x -= (dx / dist) * force * 3;
          this.y -= (dy / dist) * force * 3;
        }
      }
    }

    draw() {
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
      ctx.fillStyle = this.color;
      ctx.shadowBlur = 8;
      ctx.shadowColor = this.color;
      ctx.fill();
      ctx.shadowBlur = 0;

      // Vision Bounding Box Simulator
      if (this.isBoundingBox) {
        ctx.strokeStyle = 'rgba(56, 189, 248, 0.35)';
        ctx.lineWidth = 1;
        ctx.strokeRect(this.x - this.boxSize / 2, this.y - this.boxSize / 2, this.boxSize, this.boxSize);
        // Corner markers
        const s = 4;
        ctx.strokeStyle = '#38bdf8';
        ctx.beginPath();
        ctx.moveTo(this.x - this.boxSize/2, this.y - this.boxSize/2 + s);
        ctx.lineTo(this.x - this.boxSize/2, this.y - this.boxSize/2);
        ctx.lineTo(this.x - this.boxSize/2 + s, this.y - this.boxSize/2);
        ctx.stroke();
      }
    }
  }

  for (let i = 0; i < particleCount; i++) {
    particles.push(new Particle());
  }

  function animate() {
    ctx.clearRect(0, 0, width, height);

    // Connect particles with neural links
    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const dist = Math.sqrt(dx * dx + dy * dy);

        if (dist < 130) {
          const alpha = (1 - dist / 130) * 0.25;
          ctx.strokeStyle = `rgba(56, 189, 248, ${alpha})`;
          ctx.lineWidth = 0.8;
          ctx.beginPath();
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.stroke();
        }
      }
    }

    particles.forEach(p => {
      p.update();
      p.draw();
    });

    requestAnimationFrame(animate);
  }

  animate();
}

/* ==========================================================================
   Mobile Navigation & Drawer
   ========================================================================== */
function initMobileNav() {
  const toggle = document.querySelector('.mobile-toggle');
  const menu = document.querySelector('.nav-menu');

  if (toggle && menu) {
    toggle.addEventListener('click', (e) => {
      e.stopPropagation();
      const isActive = menu.classList.toggle('active');
      toggle.innerHTML = isActive ? '✕' : '☰';
    });

    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        menu.classList.remove('active');
        if (toggle) toggle.innerHTML = '☰';
      });
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
      if (menu.classList.contains('active') && !menu.contains(e.target) && !toggle.contains(e.target)) {
        menu.classList.remove('active');
        if (toggle) toggle.innerHTML = '☰';
      }
    });

    // Escape key closes menu and modals
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        menu.classList.remove('active');
        if (toggle) toggle.innerHTML = '☰';
        document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('active'));
      }
    });
  }
}

/* ==========================================================================
   Live Student Search & Tab Filter
   ========================================================================== */
function initStudentFilters() {
  const tabs = document.querySelectorAll('.student-filter-tab');
  const searchInput = document.getElementById('student-search-input');
  const cards = document.querySelectorAll('.student-card-item');

  if (!cards.length) return;

  let currentCategory = 'all';
  let currentSearch = '';

  function filterCards() {
    let visibleCount = 0;

    cards.forEach(card => {
      const category = card.getAttribute('data-degree') || '';
      const isAlumni = card.getAttribute('data-graduated') === '1';
      const name = (card.getAttribute('data-name') || '').toLowerCase();
      const interests = (card.getAttribute('data-interests') || '').toLowerCase();
      const thesis = (card.getAttribute('data-thesis') || '').toLowerCase();
      const supervisor = (card.getAttribute('data-supervisor') || '').toLowerCase();

      let categoryMatch = false;
      if (currentCategory === 'all') {
        categoryMatch = true;
      } else if (currentCategory === 'phd') {
        categoryMatch = category.includes('PhD') && !isAlumni;
      } else if (currentCategory === 'msc') {
        categoryMatch = category.includes('MSc') && !isAlumni;
      } else if (currentCategory === 'alumni') {
        categoryMatch = isAlumni;
      }

      const searchMatch = !currentSearch || 
        name.includes(currentSearch) || 
        interests.includes(currentSearch) || 
        thesis.includes(currentSearch) || 
        supervisor.includes(currentSearch);

      if (categoryMatch && searchMatch) {
        card.style.display = 'flex';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    const noResults = document.getElementById('no-students-msg');
    if (noResults) {
      noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    }
  }

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      currentCategory = tab.getAttribute('data-filter') || 'all';
      filterCards();
    });
  });

  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      currentSearch = e.target.value.trim().toLowerCase();
      filterCards();
    });
  }
}

/* ==========================================================================
   Publications Search & Filter
   ========================================================================== */
function initPublicationSearch() {
  const searchInput = document.getElementById('pub-search-input');
  const pubItems = document.querySelectorAll('.pub-item');

  if (!searchInput || !pubItems.length) return;

  searchInput.addEventListener('input', (e) => {
    const q = e.target.value.trim().toLowerCase();
    let count = 0;

    pubItems.forEach(item => {
      const text = item.textContent.toLowerCase();
      if (!q || text.includes(q)) {
        item.style.display = 'flex';
        count++;
      } else {
        item.style.display = 'none';
      }
    });

    const emptyMsg = document.getElementById('no-pubs-msg');
    if (emptyMsg) {
      emptyMsg.style.display = count === 0 ? 'block' : 'none';
    }
  });
}

/* ==========================================================================
   Modals & BibTeX Exporter
   ========================================================================== */
function initModals() {
  // BibTeX Modal
  const bibtexBtns = document.querySelectorAll('.btn-bibtex');
  const bibtexModal = document.getElementById('bibtex-modal');
  const bibtexCode = document.getElementById('bibtex-content');
  const copyBtn = document.getElementById('btn-copy-bibtex');

  if (bibtexBtns.length && bibtexModal && bibtexCode) {
    bibtexBtns.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const bib = btn.getAttribute('data-bibtex') || '';
        bibtexCode.textContent = bib;
        bibtexModal.classList.add('active');
      });
    });

    if (copyBtn) {
      copyBtn.addEventListener('click', () => {
        navigator.clipboard.writeText(bibtexCode.textContent).then(() => {
          const orig = copyBtn.innerHTML;
          copyBtn.innerHTML = '✓ Copied!';
          setTimeout(() => { copyBtn.innerHTML = orig; }, 2000);
        });
      });
    }
  }

  // Close Modals on close-button or backdrop click
  document.querySelectorAll('.modal-close, .modal-overlay').forEach(el => {
    el.addEventListener('click', (e) => {
      if (e.target === el) {
        document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('active'));
      }
    });
  });
}
