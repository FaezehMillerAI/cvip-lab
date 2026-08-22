/**
 * ==========================================================================
 * CVIP LAB - CORE JAVASCRIPT & UI CONTROLLERS
 * Computer Vision & Image Processing Research Laboratory
 * Lightweight, Ultra-Fast & GPU-Friendly (Zero Lag / Zero Battery Overhead)
 * ==========================================================================
 */

document.addEventListener('DOMContentLoaded', () => {
  initTheme();
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
    btn.onclick = () => {
      const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
      const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', newTheme);
      localStorage.setItem('cvip_theme', newTheme);
      updateThemeIcons(newTheme);
    };
  });
}

function updateThemeIcons(theme) {
  const themeIcons = document.querySelectorAll('.theme-toggle');
  themeIcons.forEach(btn => {
    btn.innerHTML = theme === 'dark' ? '☀️' : '🌙';
    btn.setAttribute('title', theme === 'dark' ? 'Switch to Light Mode' : 'Switch to Dark Mode');
  });
}

/* ==========================================================================
   Mobile Navigation & Drawer
   ========================================================================== */
function initMobileNav() {
  const toggle = document.querySelector('.mobile-toggle');
  const menu = document.querySelector('.nav-menu');

  if (toggle && menu) {
    toggle.onclick = (e) => {
      e.stopPropagation();
      const isActive = menu.classList.toggle('active');
      toggle.innerHTML = isActive ? '✕' : '☰';
    };

    document.querySelectorAll('.nav-link').forEach(link => {
      link.onclick = () => {
        menu.classList.remove('active');
        if (toggle) toggle.innerHTML = '☰';
      };
    });

    document.addEventListener('click', (e) => {
      if (menu.classList.contains('active') && !menu.contains(e.target) && !toggle.contains(e.target)) {
        menu.classList.remove('active');
        if (toggle) toggle.innerHTML = '☰';
      }
    });

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
      const category = (card.getAttribute('data-degree') || '').toLowerCase();
      const isAlumni = card.getAttribute('data-graduated') === '1' || 
                       card.getAttribute('data-graduated') === 'true' || 
                       category === 'alumni';
      
      const searchAttr = (card.getAttribute('data-search') || '').toLowerCase();
      const cardText = card.textContent.toLowerCase();
      const combinedSearch = searchAttr + ' ' + cardText;

      let categoryMatch = false;
      if (currentCategory === 'all') {
        categoryMatch = true;
      } else if (currentCategory === 'phd') {
        categoryMatch = (category === 'phd' || category.includes('phd')) && !isAlumni;
      } else if (currentCategory === 'msc') {
        categoryMatch = (category === 'msc' || category.includes('msc')) && !isAlumni;
      } else if (currentCategory === 'bsc') {
        categoryMatch = (category === 'bsc' || category.includes('bsc')) && !isAlumni;
      } else if (currentCategory === 'alumni') {
        categoryMatch = isAlumni || category === 'alumni';
      }

      const searchMatch = !currentSearch || combinedSearch.includes(currentSearch);

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
    tab.onclick = () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      currentCategory = tab.getAttribute('data-filter') || 'all';
      filterCards();
    };
  });

  if (searchInput) {
    searchInput.oninput = (e) => {
      currentSearch = e.target.value.trim().toLowerCase();
      filterCards();
    };
  }
}

/* ==========================================================================
   Live Publications Search & Year Tabs
   ========================================================================== */
function initPublicationSearch() {
  const tabs = document.querySelectorAll('.pub-year-tab');
  const searchInput = document.getElementById('pub-search-input');
  const items = document.querySelectorAll('.pub-item');

  if (!items.length) return;

  let activeYear = 'all';
  let activeQuery = '';

  function filterPubs() {
    let count = 0;

    items.forEach(item => {
      const year = item.getAttribute('data-year') || '';
      const text = item.textContent.toLowerCase();

      const matchYear = activeYear === 'all' || year === activeYear;
      const matchQuery = !activeQuery || text.includes(activeQuery);

      if (matchYear && matchQuery) {
        item.style.display = 'block';
        count++;
      } else {
        item.style.display = 'none';
      }
    });

    const noPubs = document.getElementById('no-pubs-msg');
    if (noPubs) {
      noPubs.style.display = count === 0 ? 'block' : 'none';
    }
  }

  tabs.forEach(tab => {
    tab.onclick = () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      activeYear = tab.getAttribute('data-year') || 'all';
      filterPubs();
    };
  });

  if (searchInput) {
    searchInput.oninput = (e) => {
      activeQuery = e.target.value.trim().toLowerCase();
      filterPubs();
    };
  }
}

/* ==========================================================================
   Modals & Popups
   ========================================================================== */
function initModals() {
  document.querySelectorAll('.modal-overlay').forEach(modal => {
    const closeBtn = modal.querySelector('.modal-close');
    if (closeBtn) {
      closeBtn.onclick = () => modal.classList.remove('active');
    }
    modal.onclick = (e) => {
      if (e.target === modal) modal.classList.remove('active');
    };
  });
}

function initAdminModal() {
  if (document.getElementById('admin-modal')) return;

  const adminModalHtml = `
  <div class="modal-overlay" id="admin-modal">
      <div class="modal-card" style="max-width: 780px; width: 94%;">
          <button class="modal-close" type="button" onclick="document.getElementById('admin-modal').classList.remove('active')">✕</button>
          <div id="admin-login-view">
              <div style="text-align: center; margin-bottom: 24px;">
                  <div style="font-size: 2.6rem; margin-bottom: 8px;">🔐</div>
                  <h2 style="font-size: 1.6rem; color: var(--text-primary); margin-bottom: 6px;">ورود به پنل مدیریت آزمایشگاه</h2>
                  <p style="color: var(--text-muted); font-size: 0.9rem;">نام کاربری: <code>admin</code> | رمز عبور: <code>admin123</code></p>
              </div>
              <div id="admin-login-err" style="display: none; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; padding: 12px; border-radius: 8px; margin-bottom: 16px; text-align: center; font-size: 0.9rem;">
                  نام کاربری یا رمز عبور اشتباه است!
              </div>
              <form id="admin-login-form" onsubmit="handleAdminLogin(event)">
                  <div class="form-group" style="margin-bottom: 16px;">
                      <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600;">نام کاربری (Username)</label>
                      <input type="text" id="adm-user" class="form-control" style="width: 100%; padding: 12px; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 8px; color: #fff;" value="admin" required>
                  </div>
                  <div class="form-group" style="margin-bottom: 20px;">
                      <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600;">رمز عبور (Password)</label>
                      <input type="password" id="adm-pass" class="form-control" style="width: 100%; padding: 12px; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 8px; color: #fff;" value="admin123" required>
                  </div>
                  <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-weight: 700;">
                      ورود به سیستم (Sign In)
                  </button>
              </form>
          </div>
      </div>
  </div>
  `;
  document.body.insertAdjacentHTML('beforeend', adminModalHtml);
}

window.openAdminModal = function() {
  initAdminModal();
  const modal = document.getElementById('admin-modal');
  if (modal) modal.classList.add('active');
};

window.handleAdminLogin = function(e) {
  if (e) e.preventDefault();
  const user = document.getElementById('adm-user')?.value.trim();
  const pass = document.getElementById('adm-pass')?.value.trim();
  const err = document.getElementById('admin-login-err');

  if (user === 'admin' && pass === 'admin123') {
    if (err) err.style.display = 'none';
    const loginView = document.getElementById('admin-login-view');
    const dashView = document.getElementById('admin-dash-view');
    if (loginView) loginView.style.display = 'none';
    if (dashView) dashView.style.display = 'block';
  } else {
    if (err) err.style.display = 'block';
  }
};

window.handleAdminLogout = function() {
  const loginView = document.getElementById('admin-login-view');
  const dashView = document.getElementById('admin-dash-view');
  if (dashView) dashView.style.display = 'none';
  if (loginView) loginView.style.display = 'block';
};
