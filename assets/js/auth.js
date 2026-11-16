// Auth: manual intro slides, password visibility, and notices for services not connected yet.
// Required hooks: .js-component-auth-intro, -intro-counter, -password-toggle, -notice, -notice-description.
(() => {
  document.querySelectorAll('.js-component-auth-intro').forEach((intro) => {
    const slides = [...intro.querySelectorAll('[data-auth-slide]')];
    const buttons = [...intro.querySelectorAll('[data-auth-slide-target]')];
    const counter = intro.querySelector('.js-component-auth-intro-counter');

    buttons.forEach((button, index) => {
      button.addEventListener('click', () => {
        slides.forEach((slide, slideIndex) => slide.classList.toggle('hidden', slideIndex !== index));
        buttons.forEach((control, controlIndex) => {
          if (controlIndex === index) {
            control.setAttribute('aria-current', 'true');
          } else {
            control.removeAttribute('aria-current');
          }
        });
        if (counter) {
          counter.textContent = `${String(index + 1).padStart(2, '0')} / ${String(slides.length).padStart(2, '0')}`;
        }
      });
    });
  });

  document.querySelectorAll('.js-component-auth-password-toggle').forEach((toggle) => {
    const password = document.getElementById(toggle.getAttribute('aria-controls'));
    if (!password) return;

    toggle.addEventListener('change', () => {
      password.type = toggle.checked ? 'text' : 'password';
    });
  });

  const notice = document.querySelector('.js-component-auth-notice');
  if (!notice) return;

  const description = notice.querySelector('.js-component-auth-notice-description');
  const messages = {
    google: 'Google sign-in is not available yet. Please try again once account access is enabled.',
    apple: 'Apple sign-in is not available yet. Please try again once account access is enabled.',
    privacy: 'The Privacy Policy is not available yet. Please check back before creating an account.',
  };

  document.querySelectorAll('[data-auth-notice]').forEach((button) => {
    button.addEventListener('click', () => {
      description.textContent = messages[button.dataset.authNotice];
      notice.showModal();
    });
  });
})();
