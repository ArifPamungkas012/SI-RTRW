// public/js/dashboard.js (gabungan final)
// Features: deterministic flow open->icons->closed->open,
// first-time open default, submenu animations, robust toggle wiring (outermost only)
document.addEventListener('DOMContentLoaded', function () {
  try { if (window.lucide) lucide.createIcons(); } catch (e) { /* ignore */ }

  const appRoot = document.getElementById('appRoot');
  const sidebar = document.getElementById('sidebar');

  if (!appRoot || !sidebar) {
    console.error('Dashboard init: missing #appRoot or #sidebar element.');
    return;
  }

  // Candidate toggle selectors
  const toggleSelectors = ['#sidebarToggle', '#headerSidebarToggle', '[data-toggle-sidebar]'];
  const foundToggles = toggleSelectors.flatMap(sel => Array.from(document.querySelectorAll(sel)));
  let uniqueToggleButtons = Array.from(new Set(foundToggles));

  // FILTER: keep only outermost toggles (remove any toggle contained by another toggle)
  uniqueToggleButtons = uniqueToggleButtons.filter(el =>
    !uniqueToggleButtons.some(other => other !== el && other.contains(el))
  );

  if (uniqueToggleButtons.length === 0) {
    console.warn('No sidebar toggle button found. Add id="sidebarToggle" or data-toggle-sidebar attribute.');
  }

  const menuItems = document.querySelectorAll('.menu-item');
  const submenuContainers = document.querySelectorAll('.sidebar-submenu');
  const submenuButtons = document.querySelectorAll('.submenu-item');

  // states
  const STATES = ['open', 'icons', 'closed'];

  // load or initialize state: ensure first time -> open
  let idx = 0;
  try {
    const saved = localStorage.getItem('si.sidebar.state');
    if (!saved) {
      localStorage.setItem('si.sidebar.state', 'open');
      idx = STATES.indexOf('open');
    } else if (STATES.includes(saved)) {
      idx = STATES.indexOf(saved);
    }
  } catch (e) { console.warn('localStorage error, fallback to open mode'); idx = 0; }

  // helpers for submenu animation
  function openSubmenu(el) {
    if (!el) return;
    el.classList.remove('hidden');
    el.style.display = 'block';
    const h = el.scrollHeight;
    el.style.overflow = 'hidden';
    el.style.maxHeight = '0px';
    requestAnimationFrame(() => {
      el.style.transition = 'max-height 260ms ease';
      el.style.maxHeight = h + 'px';
    });
    el.setAttribute('aria-hidden', 'false');
  }
  function closeSubmenu(el) {
    if (!el) return;
    el.style.overflow = 'hidden';
    el.style.transition = 'max-height 200ms ease';
    el.style.maxHeight = el.scrollHeight + 'px';
    requestAnimationFrame(() => {
      el.style.maxHeight = '0px';
    });
    const onEnd = function (e) {
      if (e.propertyName === 'max-height') {
        el.classList.add('hidden');
        el.style.removeProperty('max-height');
        el.style.removeProperty('transition');
        el.style.removeProperty('display');
        el.removeEventListener('transitionend', onEnd);
      }
    };
    el.addEventListener('transitionend', onEnd);
    el.setAttribute('aria-hidden', 'true');
  }

  // ensure visible before transition
  function ensureSidebarShownForTransition() {
    sidebar.classList.remove('hidden-complete');
    sidebar.style.pointerEvents = '';
  }

  function markHiddenCompleteAfterTransition() {
    sidebar.classList.remove('hidden-complete');
    const onEnd = function (ev) {
      if (['transform', 'opacity', 'width'].includes(ev.propertyName)) {
        sidebar.classList.add('hidden-complete');
        sidebar.style.pointerEvents = 'none';
        sidebar.removeEventListener('transitionend', onEnd);
      }
    };
    sidebar.removeEventListener('transitionend', onEnd);
    sidebar.addEventListener('transitionend', onEnd);
  }

  function applyState() {
    ensureSidebarShownForTransition();

    sidebar.classList.remove('sidebar-open', 'sidebar-icons', 'sidebar-closed');
    if (STATES[idx] === 'open') sidebar.classList.add('sidebar-open');
    if (STATES[idx] === 'icons') sidebar.classList.add('sidebar-icons');
    if (STATES[idx] === 'closed') sidebar.classList.add('sidebar-closed');

    appRoot.classList.remove('sidebar-state-open', 'sidebar-state-icons', 'sidebar-state-closed');
    appRoot.classList.add('sidebar-state-' + STATES[idx]);

    if (STATES[idx] !== 'open') {
      submenuContainers.forEach(s => {
        if (!s.classList.contains('hidden')) {
          s.classList.add('hidden');
          s.style.removeProperty('max-height');
          s.style.removeProperty('display');
          s.setAttribute('aria-hidden', 'true');
        }
      });
    }

    try { localStorage.setItem('si.sidebar.state', STATES[idx]); } catch (e) { /* ignore */ }

    if (STATES[idx] === 'closed') {
      markHiddenCompleteAfterTransition();
    } else {
      sidebar.classList.remove('hidden-complete');
      sidebar.style.pointerEvents = '';
    }
  }

  // init submenu states
  submenuContainers.forEach(s => {
    if (!s.classList.contains('hidden')) s.setAttribute('aria-hidden', 'false');
    else s.setAttribute('aria-hidden', 'true');
    s.style.overflow = 'hidden';
    s.style.maxHeight = s.classList.contains('hidden') ? '0px' : (s.scrollHeight + 'px');
  });

  // menu item wiring
  menuItems.forEach(mi => {
    const hasSub = mi.getAttribute('data-has-submenu') === 'true';
    const subId = mi.getAttribute('data-submenu');

    mi.setAttribute('role', 'button');
    mi.setAttribute('tabindex', '0');
    if (hasSub && subId) mi.setAttribute('aria-expanded', 'false');

    mi.addEventListener('click', function (e) {
      if (hasSub && appRoot.classList.contains('sidebar-state-open')) {
        const target = document.getElementById(subId);
        if (!target) return;
        const isHidden = target.classList.contains('hidden');
        submenuContainers.forEach(s => {
          if (s.id !== subId && !s.classList.contains('hidden')) closeSubmenu(s);
          const parentBtn = document.querySelector(`[data-submenu="${s.id}"]`);
          if (parentBtn) parentBtn.setAttribute('aria-expanded', 'false');
        });
        if (isHidden) {
          openSubmenu(target);
          this.setAttribute('aria-expanded', 'true');
        } else {
          closeSubmenu(target);
          this.setAttribute('aria-expanded', 'false');
        }
      } else {
        menuItems.forEach(m => m.classList.remove('active'));
        this.classList.add('active');
        submenuContainers.forEach(s => { if (!s.classList.contains('hidden')) closeSubmenu(s); });
        menuItems.forEach(m => m.setAttribute('aria-expanded', 'false'));
        this.setAttribute('aria-expanded', 'false');
      }
    });

    mi.addEventListener('keydown', function (ev) {
      if (ev.key === 'Enter' || ev.key === ' ') {
        ev.preventDefault();
        mi.click();
      }
    });
  });

  // submenu visuals
  submenuButtons.forEach(sb => {
    sb.setAttribute('role', 'button');
    sb.setAttribute('tabindex', '0');
    sb.addEventListener('click', function (e) {
      e.stopPropagation();
      submenuButtons.forEach(s => s.style.background = '');
      this.style.background = 'rgba(16,185,129,0.06)';
    });
    sb.addEventListener('keydown', function (ev) {
      if (ev.key === 'Enter' || ev.key === ' ') {
        ev.preventDefault();
        sb.click();
      }
    });
  });

  // EXPLICIT next-state mapping to guarantee order: open -> icons -> closed -> open
  function nextStateFrom(currentState) {
    switch (currentState) {
      case 'open': return 'icons';
      case 'icons': return 'closed';
      case 'closed': return 'open';
      default: return 'open';
    }
  }

  // apply initial state
  applyState();

  // attach toggle to all outermost found buttons (robust)
  uniqueToggleButtons.forEach(btn => {
    try {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        const current = STATES[idx] || 'open';
        const next = nextStateFrom(current);
        idx = STATES.indexOf(next);
        applyState();
      });
      btn.setAttribute('tabindex', '0');
      btn.addEventListener('keydown', function (ev) {
        if (ev.key === 'Enter' || ev.key === ' ') {
          ev.preventDefault();
          btn.click();
        }
      });
    } catch (e) {
      console.warn('Failed to attach listener to toggle button', btn, e);
    }
  });

  // fallback toggle if none found
  if (uniqueToggleButtons.length === 0) {
    const fallback = document.createElement('button');
    fallback.style.position = 'fixed';
    fallback.style.right = '12px';
    fallback.style.bottom = '12px';
    fallback.style.width = '40px';
    fallback.style.height = '40px';
    fallback.style.zIndex = '2000';
    fallback.title = 'Toggle sidebar (fallback)';
    fallback.innerText = '≡';
    fallback.setAttribute('aria-label', 'Toggle sidebar (fallback)');
    document.body.appendChild(fallback);
    fallback.addEventListener('click', () => {
      const current = STATES[idx] || 'open';
      const next = nextStateFrom(current);
      idx = STATES.indexOf(next);
      applyState();
      setTimeout(() => fallback.remove(), 200);
    });
    console.info('Fallback sidebar toggle created (temporary) — add id="sidebarToggle" to your header button for production.');
  }

  // click outside behavior
  document.addEventListener('click', function (ev) {
    const isInside = sidebar.contains(ev.target) || uniqueToggleButtons.some(b => b.contains(ev.target));
    if (!isInside && appRoot.classList.contains('sidebar-state-closed')) {
      idx = STATES.indexOf('icons');
      applyState();
    }
  });

  // dev shortcut
  document.addEventListener('keydown', function (ev) {
    if (ev.key.toLowerCase() === 'b') {
      const current = STATES[idx] || 'open';
      const next = nextStateFrom(current);
      idx = STATES.indexOf(next);
      applyState();
    }
  });

  try { if (window.lucide) lucide.createIcons(); } catch (e) { /* ignore */ }
});
