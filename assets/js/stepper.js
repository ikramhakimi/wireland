// Stepper: step a number input with minus/plus buttons, clamp typed values to min/max, sync disabled states.
// Hooks: .js-component-stepper containing .js-component-stepper-{decrease,input,increase}.
(() => {
  document.querySelectorAll('.js-component-stepper').forEach((root) => {
    const input    = root.querySelector('.js-component-stepper-input');
    const decrease = root.querySelector('.js-component-stepper-decrease');
    const increase = root.querySelector('.js-component-stepper-increase');
    if (!input || !decrease || !increase) return;

    const min  = input.min === '' ? 1 : Number(input.min);
    const max  = input.max === '' ? Infinity : Number(input.max);
    const step = Number(input.step) || 1;
    const clamp = (value) => Math.min(max, Math.max(min, Number.isFinite(value) ? Math.round(value) : min));
    const sync = () => {
      const value = Number(input.value);
      decrease.disabled = input.disabled || value <= min;
      increase.disabled = input.disabled || value >= max;
    };
    const set = (value) => {
      input.value = clamp(value);
      input.dispatchEvent(new Event('change', { bubbles: true }));
      sync();
    };

    decrease.addEventListener('click', () => set(Number(input.value) - step));
    increase.addEventListener('click', () => set(Number(input.value) + step));
    input.addEventListener('input', sync);
    input.addEventListener('blur', () => set(Number(input.value)));
    sync();
  });
})();
