<?php

// Home 4 — lander with the C2 "assessment-first" hero (three-question mini assessment + live starting kit).
// Hero markup, data and Tailwind styling live in views/sections/home-hero-quiz.php.
// Hero JS lives inline at the bottom of this page for now.
require_once __DIR__ . '/../../includes/store.php';

$page_title       = 'Lander';
$page_description = '';
$page_current     = 'home';

component('navbar', ['cart_href' => asset_url('cart/')]);
section('home-hero-quiz', [
  'store_products' => $store_products,
  'store_token'    => $store_token,
]);
section('how-it-works-timeline');
section('home-life-results', ['headline_alignment' => 'left']);
section('home-shop', ['store_products' => $store_products]);
section('home-hair-cycle', ['headline_alignment' => 'left']);
section('home-treatments', ['headline_alignment' => 'left']);
section('home-life-team', ['headline_alignment' => 'left']);
section('home-faq', ['headline_alignment' => 'left']);
section('footer', ['show_banner' => true]);

component('button-whatsapp');
component('button-getstart');
?>
<script>
  // Hero mini assessment (from prototype C2): steps run in place; answers are assessment links without JS.
  // After answer 1 the kit swaps to the concern's products. After answer 3 the result names the concern and shows
  // the doctor step matching the goal. "Add all" posts each product to the store handler, then opens the cart.
  // Hooks: .js-component-hc-quiz (root), -step, -answer[data-name/value/label/short], -back, -progress, -fill,
  // -result, -summary, -summary-item (<template>), -summary-label, -done-title, -kit[data-goal, data-cart], -kit-title, -kit-set[data-concern],
  // -kit-doctor, -doctor-step[data-goal], -note, -continue, -add[data-ids], -add-status, -token.
  (() => {
    const root = document.querySelector('.js-component-hc-quiz');
    if (!root) return;

    const q             = (selector) => root.querySelector(selector);
    const steps         = Array.from(root.querySelectorAll('.js-component-hc-step'));
    const done          = q('.js-component-hc-result');
    const doneTitle     = q('.js-component-hc-done-title');
    const back          = q('.js-component-hc-back');
    const progress      = q('.js-component-hc-progress');
    const fill          = q('.js-component-hc-fill');
    const summary       = q('.js-component-hc-summary');
    const summaryItem   = q('.js-component-hc-summary-item');
    const kit           = q('.js-component-hc-kit');
    const kitTitle      = q('.js-component-hc-kit-title');
    const kitSets       = Array.from(root.querySelectorAll('.js-component-hc-kit-set'));
    const kitDoctor     = q('.js-component-hc-kit-doctor');
    const doctorSteps   = Array.from(root.querySelectorAll('.js-component-hc-doctor-step'));
    const note          = q('.js-component-hc-note');
    const continueLinks = Array.from(root.querySelectorAll('.js-component-hc-continue'));
    const status        = q('.js-component-hc-add-status');
    const token         = q('.js-component-hc-token')?.value || '';
    const fields        = ['concern', 'noticed', 'goal'];
    const answers       = {};
    const labels        = {};
    let current         = 0;

    const concernShort = () => q(`.js-component-hc-answer[data-name="concern"][data-value="${answers.concern}"]`)
      ?.dataset.short || 'your hair';

    const showKit = () => {
      const concern = answers.concern || 'popular';
      kitSets.forEach((set) => {
        set.hidden = set.dataset.concern !== concern;
      });
      kitTitle.textContent = answers.concern ? `Everyday care for ${concernShort()}` : 'Popular to start with';
    };

    const showDoctor = (visible) => {
      kitDoctor.hidden = !visible;
      kit.dataset.goal = visible ? answers.goal || '' : '';
      if (!visible) return;

      const goal = doctorSteps.some((step) => step.dataset.goal === answers.goal) ? answers.goal : 'unsure';
      doctorSteps.forEach((step) => {
        step.hidden = step.dataset.goal !== goal;
      });
      continueLinks.forEach((link) => {
        const url = new URL(link.href, window.location.href);
        url.search = '';
        fields.forEach((name) => {
          if (answers[name]) url.searchParams.set(name, answers[name]);
        });
        link.href = url.pathname + url.search;
      });
      if (note) note.hidden = answers.noticed !== 'long' || goal === 'doctor';
    };

    const show = (index) => {
      current = index;
      const finished = index >= steps.length;
      steps.forEach((step, i) => {
        step.hidden = i !== index;
      });
      done.hidden = !finished;
      back.hidden = index === 0;
      root.classList.toggle('is-started', index > 0);
      progress.textContent = finished ? `All ${steps.length} answered` : `Question ${index + 1} of ${steps.length}`;
      fill.style.width = `${(Math.min(index, steps.length) / steps.length) * 100}%`;
      showKit();
      showDoctor(finished);

      if (finished) {
        doneTitle.textContent = `A starting point for ${concernShort()}`;
        summary.replaceChildren(...fields.filter((name) => labels[name]).map((name) => {
          const item = summaryItem.content.firstElementChild.cloneNode(true);
          item.querySelector('.js-component-hc-summary-label').textContent = labels[name];
          return item;
        }));
      }

      (finished ? done : steps[index]).querySelector('[tabindex="-1"]')?.focus({ preventScroll: true });
    };

    const reset = () => {
      Object.keys(answers).forEach((key) => delete answers[key]);
      Object.keys(labels).forEach((key) => delete labels[key]);
    };

    root.addEventListener('click', (event) => {
      const answer = event.target instanceof Element ? event.target.closest('.js-component-hc-answer') : null;
      if (!answer) return;
      event.preventDefault();
      answers[answer.dataset.name] = answer.dataset.value;
      labels[answer.dataset.name]  = answer.dataset.label;
      show(current + 1);
    });

    back.addEventListener('click', () => {
      const target = Math.max(0, current - 1);
      if (target === 0) reset();
      show(target);
    });

    root.querySelectorAll('.js-component-hc-add').forEach((button) => {
      button.addEventListener('click', async () => {
        const ids = (button.dataset.ids || '').split(',').filter(Boolean);
        button.disabled    = true;
        status.textContent = 'Adding to your cart…';
        try {
          for (const id of ids) {
            const body     = new URLSearchParams({ token, product_id: id, quantity: '1', cart_action: 'add' });
            const response = await fetch(window.location.pathname, {
              method: 'POST',
              body,
              credentials: 'same-origin',
            });
            if (!response.ok) throw new Error(String(response.status));
          }
          status.textContent   = 'Added. Opening your cart…';
          window.location.href = kit.dataset.cart;
        } catch (error) {
          status.textContent = 'Could not add everything. Please try again or open each product.';
          button.disabled    = false;
        }
      });
    });

    show(0);
  })();
</script>
