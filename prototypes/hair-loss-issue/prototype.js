const variants = ['connected', 'clinical', 'split'].map((name) => () =>
  document.getElementById(`variant-${name}`).innerHTML
);
