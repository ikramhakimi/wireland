// Isolated drawer harness: delegated data actions survive picker re-mounts.
const variants = ['compact', 'editorial', 'drilldown'].map(name => () =>
  document.getElementById(`variant-${name}`).innerHTML
);
const context = document.querySelector('.prototype-context');
const openButton = document.querySelector('[data-open]');
let closeTimer;

function closeDrawer() {
  const overlay = document.querySelector('.drawer-overlay');
  if (!overlay || overlay.hasAttribute('data-closing')) return;
  overlay.setAttribute('data-closing', '');
  closeTimer = setTimeout(() => {
    overlay.remove();
    openButton.inert = false;
    openButton.focus();
  }, matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 180);
}

function showContent(html) {
  const body = document.querySelector('.drawer-body');
  const navigation = body.querySelector('.drawer-navigation');
  navigation.hidden = true;
  body.querySelector('.drawer-preview')?.remove();
  const panel = document.createElement('section');
  panel.className = 'drawer-preview';
  panel.innerHTML = html;
  body.append(panel);
  body.scrollTop = 0;
  panel.querySelector('h1')?.focus();
}

function goBack() {
  const body = document.querySelector('.drawer-body');
  body.querySelector('.drawer-preview')?.remove();
  body.querySelector('.drawer-navigation').hidden = false;
  body.querySelector('[data-category], summary')?.focus();
}

document.addEventListener('click', event => {
  const target = event.target.closest('button');
  if (!target) return;
  if (target.hasAttribute('data-close')) closeDrawer();
  if (target.hasAttribute('data-open')) mount(current);
  if (target.hasAttribute('data-back')) goBack();
  if (target.dataset.category) {
    const template = [...document.querySelectorAll('#stage template[data-submenu]')]
      .find(item => item.dataset.submenu === target.dataset.category);
    showContent(template.innerHTML);
  }
  if (target.dataset.topic) {
    const topic = target.dataset.topic;
    const container = document.createElement('div');
    const heading = document.createElement('h1');
    heading.className = 'drawer-title';
    heading.tabIndex = -1;
    heading.textContent = topic;
    container.append(heading);
    showContent(`<button class="drawer-back" type="button" data-topic-back>Back</button>
      <p class="drawer-eyebrow">Navigation preview</p>${container.innerHTML}
      <p class="drawer-preview-copy">You selected ${heading.innerHTML}. This isolated prototype previews
      the menu interaction. Content pages are not connected in this exploration.</p>
      <a class="drawer-preview-link" href="../../home-lifestyle">Visit HairClinic home</a>`);
  }
  if (target.hasAttribute('data-topic-back')) {
    // Return to the category list; accordion state is retained in the original DOM.
    goBack();
  }
});

document.addEventListener('keydown', event => {
  const drawer = document.querySelector('#stage .drawer');
  if (!drawer) return;
  if (event.key === 'Escape') closeDrawer();
  if (event.key !== 'Tab') return;
  const focusable = [...drawer.querySelectorAll('a, button, summary, [tabindex="0"]'),
    ...document.querySelectorAll('.proto-picker button')]
    .filter(element => element.getClientRects().length && !element.disabled);
  const first = focusable[0];
  const last = focusable[focusable.length - 1];
  if (event.shiftKey && (document.activeElement === first || document.activeElement === drawer)) {
    event.preventDefault();
    last.focus();
  } else if (!event.shiftKey && document.activeElement === last) {
    event.preventDefault();
    first.focus();
  }
});

new MutationObserver(() => {
  const drawer = document.querySelector('#stage .drawer');
  if (!drawer) return;
  clearTimeout(closeTimer);
  context.inert = true;
  openButton.inert = true;
  drawer.focus({ preventScroll: true });
}).observe(document.getElementById('stage'), { childList: true });
