// Help topic nav: highlight current section from hash / scroll.
export default function helpPage() {
  const nav = document.querySelector('.s-help-topics__nav');
  if (!nav) return;

  const links = [...nav.querySelectorAll('a[href*="#"]')];
  if (!links.length) return;

  const sections = links
    .map((a) => {
      const id = (a.getAttribute('href') || '').split('#')[1] || 'faq';
      const el = document.getElementById(id) || (id === 'faq' ? document.getElementById('top') : null);
      return { id, a, el };
    })
    .filter((x) => x.el);

  function setOn(id) {
    links.forEach((a) => {
      const hid = (a.getAttribute('href') || '').split('#')[1] || 'faq';
      const on = hid === id;
      a.classList.toggle('is-on', on);
      if (on) a.setAttribute('aria-current', 'page');
      else a.removeAttribute('aria-current');
    });
  }

  function fromHash() {
    const raw = (location.hash || '#faq').slice(1) || 'faq';
    setOn(raw);
  }

  fromHash();
  window.addEventListener('hashchange', fromHash);

  if (!('IntersectionObserver' in window)) return;
  const io = new IntersectionObserver(
    (entries) => {
      const visible = entries
        .filter((e) => e.isIntersecting)
        .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
      if (!visible) return;
      const hit = sections.find((s) => s.el === visible.target);
      if (hit) setOn(hit.id);
    },
    { rootMargin: '-20% 0px -55% 0px', threshold: [0.1, 0.25, 0.5] }
  );
  sections.forEach((s) => io.observe(s.el));
}
