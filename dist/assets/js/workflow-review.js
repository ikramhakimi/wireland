// Documentation-only demo: preview responses in the DOM; no storage or network requests.
// Hooks: .js-component-workflow-review and its -status, -preview, -meta, -response, -value children.
(() => {
  document.querySelectorAll('.js-component-workflow-review').forEach((form) => {
    const status = form.querySelector('.js-component-workflow-status');
    const preview = form.querySelector('.js-component-workflow-preview');
    const meta = form.querySelector('.js-component-workflow-meta');
    const response = form.querySelector('.js-component-workflow-response');
    const value = form.querySelector('.js-component-workflow-value');
    const submit = form.querySelector('button[type="submit"]');

    submit.disabled = false;
    submit.classList.remove('button-disabled');

    form.addEventListener('submit', (event) => {
      event.preventDefault();
      const data = new FormData(form);
      const doctorName = data.get('doctor_name').trim();
      const responseText = data.get('response').trim();
      if (!doctorName || !responseText) {
        status.textContent = 'Enter a doctor name and response using more than spaces.';
        form.elements.namedItem(!doctorName ? 'doctor_name' : 'response').focus();
        return;
      }

      const timestamp = new Intl.DateTimeFormat('en-MY', {
        dateStyle: 'medium',
        timeStyle: 'short',
        timeZone: 'Asia/Kuala_Lumpur',
      }).format(new Date());
      meta.textContent = `${doctorName} · ${data.get('review_status')} · ${timestamp} (Asia/Kuala_Lumpur)`;
      response.textContent = responseText;
      const suggestedValue = data.get('suggested_value').trim();
      value.textContent = suggestedValue ? `Suggested value: ${suggestedValue}` : '';
      value.hidden = !suggestedValue;
      preview.hidden = false;
      status.textContent = 'Demo response preview updated. Nothing has been sent or saved.';
    });

    form.addEventListener('reset', () => {
      preview.hidden = true;
      meta.textContent = '';
      response.textContent = '';
      value.textContent = '';
      value.hidden = true;
      status.textContent = 'Demo cleared.';
    });
  });
})();
