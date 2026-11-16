// Shared disclosure behavior, including controls inserted after page load.
// Required hook: .js-component-toggle-collapse with aria-controls and aria-expanded.
// The controlled panel's initial hidden state must match aria-expanded.
document.addEventListener('click', (event) => {
  if (!(event.target instanceof Element)) return;
  const toggle = event.target.closest('.js-component-toggle-collapse');
  if (!toggle) return;

  const panel = document.getElementById(toggle.getAttribute('aria-controls'));
  if (!panel) return;

  const expanded = toggle.getAttribute('aria-expanded') === 'true';
  if (expanded) {
    panel.querySelectorAll('[popover]:popover-open').forEach((popover) => popover.hidePopover());
  }
  toggle.setAttribute('aria-expanded', String(!expanded));
  panel.hidden = expanded;
});
