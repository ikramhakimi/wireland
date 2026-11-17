// Gallery: thumbnails switch the visible main image; the video thumbnail opens the shared modal (modal.js).
// Required hooks: .js-component-gallery with -image (stage images) and -thumb[data-index] children.
// Optional: .js-component-gallery-video inside the modal is paused when the modal closes.
(() => {
  document.querySelectorAll('.js-component-gallery').forEach((gallery) => {
    const images = gallery.querySelectorAll('.js-component-gallery-image');
    const thumbs = gallery.querySelectorAll('.js-component-gallery-thumb');

    thumbs.forEach((thumb) => {
      thumb.addEventListener('click', () => {
        const active = Number(thumb.dataset.index);

        images.forEach((image, index) => { image.hidden = index !== active; });
        thumbs.forEach((item) => item.setAttribute('aria-current', item === thumb ? 'true' : 'false'));
      });
    });

    const modal = document.getElementById(`${gallery.id}-video`);
    const video = modal?.querySelector('.js-component-gallery-video');
    modal?.addEventListener('close', () => video?.pause());
  });
})();
