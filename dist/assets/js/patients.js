// Preview on tablet/desktop; preserve real patient links on mobile and modified clicks.
// Required hook: .js-component-patients-preview with aria-controls pointing to its drawer.
// Rows hook: form.js-component-patients-size submits when its select changes.
// Register before drawer.js so the shared handler can open the promoted trigger.
(() => {
  const previewViewport = window.matchMedia('(min-width: 48rem)');

  document.addEventListener('click', (event) => {
    const link = event.target.closest('.js-component-patients-preview');
    if (!link) return;
    link.classList.toggle('js-component-drawer-open', previewViewport.matches);
  });

  document.addEventListener('change', (event) => {
    if (!event.target.matches('select')) return;
    event.target.closest('form.js-component-patients-size')?.requestSubmit();
  });

  previewViewport.addEventListener('change', (event) => {
    if (event.matches) return;
    document.querySelectorAll('.js-component-patients-preview').forEach((link) => {
      link.classList.remove('js-component-drawer-open');
      const drawer = document.getElementById(link.getAttribute('aria-controls'));
      if (drawer?.open) drawer.close();
    });
  });
})();

// More-menu demo feedback; no patient data is changed.
// Required hooks: .patient-row and .js-component-patients-action-status.
document.addEventListener('dropdown:select', (event) => {
  const row = event.target.closest('.patient-row');
  const status = document.querySelector('.js-component-patients-action-status');
  if (!row || !status) return;

  const name = row.querySelector('.patient-name')?.textContent.trim() ?? '';
  status.textContent = `${event.detail.label}: ${name}. Demo only; no patient data changed.`;
  status.hidden = false;
});

// Group the current PHP-filtered page without duplicating records or preview controls.
// Required hooks: .js-component-patients-group-switch, -directory, -head, -row, -all, -group, -group-list, -group-count, -group-value.
(() => {
  const control = document.querySelector('.js-component-patients-group-switch');
  const directory = document.querySelector('.js-component-patients-directory');
  if (!control || !directory) return;

  const rows = Array.from(directory.querySelectorAll('.js-component-patients-row'))
    .sort((a, b) => Number(a.dataset.order) - Number(b.dataset.order));
  const all = directory.querySelector('.js-component-patients-all');
  const groups = Array.from(directory.querySelectorAll('.js-component-patients-group'));

  control.addEventListener('change', () => {
    directory.querySelectorAll('[popover]:popover-open').forEach((panel) => panel.hidePopover());
    const grouped = control.checked;
    if (!grouped) all.append(...rows);
    groups.forEach((group) => {
      const matched = rows.filter((row) => row.dataset.followUp === group.dataset.group);
      if (grouped) group.querySelector('.js-component-patients-group-list').append(...matched);
      group.hidden = !grouped || matched.length === 0;
      group.querySelector('.js-component-patients-group-count').textContent =
        `${matched.length} ${matched.length === 1 ? 'patient' : 'patients'}`;
    });
    all.hidden = grouped;
    directory.querySelector('.js-component-patients-head').hidden = grouped;
    const value = grouped ? 'follow_up' : 'none';
    document.querySelectorAll('.js-component-patients-group-value').forEach((input) => {
      input.value = value;
    });
    const url = new URL(window.location.href);
    url.searchParams.set('group_by', value);
    window.history.replaceState(null, '', url);
  });
})();


