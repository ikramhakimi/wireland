// Product share: opens the native share sheet, or copies the page link when sharing is unsupported.
// Required hooks: .js-component-product-share (button) inside .product-share with .product-share-status.
(() => {
  const button = document.querySelector('.js-component-product-share');

  if (!button) return;

  const status = button.closest('.product-share')?.querySelector('.product-share-status');
  const share_data = { title: document.title, url: window.location.href };

  const announce = (message) => {
    if (status) status.textContent = message;
  };

  button.addEventListener('click', async () => {
    announce('');

    try {
      if (navigator.share) {
        await navigator.share(share_data);
        return;
      }

      await navigator.clipboard.writeText(share_data.url);
      announce('Link copied');
    } catch (error) {
      if (error.name !== 'AbortError') announce('Could not share. Copy the link from your browser.');
    }
  });
})();
