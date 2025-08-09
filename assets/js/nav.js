(function () {
  const btn = document.querySelector('.menu-toggle');
  const nav = document.querySelector('#primary-menu');
  const overlay = document.querySelector('.nav-overlay');
  if (!btn || !nav || !overlay) return;

  function openNav() {
    btn.setAttribute('aria-expanded', 'true');
    document.body.classList.add('nav-open');
    overlay.hidden = false;
  }
  function closeNav() {
    btn.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('nav-open');
    overlay.hidden = true;
  }

  btn.addEventListener('click', () => {
    const expanded = btn.getAttribute('aria-expanded') === 'true';
    expanded ? closeNav() : openNav();
  });

  overlay.addEventListener('click', closeNav);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && document.body.classList.contains('nav-open')) {
      closeNav();
    }
  });
})();
