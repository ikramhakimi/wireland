// Hero exploration: delegated DOM hooks survive picker remounts. Answers remain in memory only.
const heroProducts = JSON.parse(document.getElementById('hero-products-data').textContent);
const heroQuestions = JSON.parse(document.getElementById('hero-questions-data').textContent);
const heroDialog = document.querySelector('.js-component-hero-dialog');
const heroDialogContent = document.querySelector('.js-component-hero-dialog-content');
const variants = ['lifestyle', 'discovery', 'proof'].map((name) => {
  return () => document.getElementById(`variant-${name}`).innerHTML;
});
let heroProduct = 0;
let heroStep = 0;
let heroAnswers = [];
let heroDialogTrigger = null;

function renderHeroDialog(templateId, focusHeading = true) {
  heroDialogContent.replaceChildren(document.getElementById(templateId).content.cloneNode(true));
  if (!heroDialog.open) heroDialog.showModal();
  if (focusHeading) heroDialogContent.querySelector('h2').focus();
  heroDialog.scrollTop = 0;
}

function openHeroDialog(templateId, trigger) {
  if (!heroDialog.open) heroDialogTrigger = trigger;
  renderHeroDialog(templateId);
}

function selectHeroProduct(index) {
  const product = heroProducts[index];
  if (!product) return;
  heroProduct = index;
  const stage = document.getElementById('stage');
  const image = stage.querySelector('.js-component-hero-product-image');
  if (!image) return;

  image.src = product.image;
  image.alt = product.alt;
  stage.querySelector('.js-component-hero-product-stage').dataset.tone = product.tone;
  stage.querySelector('.js-component-hero-product-name').textContent = product.name;
  stage.querySelector('.js-component-hero-product-tag').textContent = product.tag;
  stage.querySelector('.js-component-hero-product-title').textContent = product.headline;
  stage.querySelector('.js-component-hero-product-description').textContent = product.description;
  stage.querySelector('.js-component-hero-product-count').textContent = `0${index + 1} / 03`;
  stage.querySelectorAll('.js-component-hero-product-option').forEach((button) => {
    button.setAttribute('aria-pressed', String(Number(button.dataset.product) === index));
  });
}

function selectExplorerProduct(index) {
  const product = heroProducts[index];
  if (!product) return;
  const image = heroDialogContent.querySelector('.js-component-hero-explorer-image');
  image.src = product.image;
  image.alt = product.alt;
  image.parentElement.dataset.tone = product.tone;
  heroDialogContent.querySelector('.js-component-hero-explorer-title').textContent = product.name;
  heroDialogContent.querySelector('.js-component-hero-explorer-description').textContent = product.detail;
  heroDialogContent.querySelectorAll('.js-component-hero-explorer-option').forEach((button) => {
    button.setAttribute('aria-pressed', String(Number(button.dataset.product) === index));
  });
}

function renderHeroQuestion() {
  const question = heroQuestions[heroStep];
  renderHeroDialog('assessment-question', false);
  heroDialogContent.querySelector('.js-component-hero-step').textContent = `Question ${heroStep + 1} of ${heroQuestions.length}`;
  heroDialogContent.querySelector('.js-component-hero-question').textContent = question.title;
  heroDialogContent.querySelector('.js-component-hero-question-hint').textContent = question.hint;
  const options = heroDialogContent.querySelector('.js-component-hero-options');
  question.options.forEach((label, index) => {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'assessment-option text-left text-sm text-zinc-800 js-component-hero-answer';
    button.dataset.answer = label;
    button.setAttribute('aria-pressed', String(heroAnswers[heroStep] === label));
    const number = document.createElement('span');
    number.className = 'assessment-option-number text-xs text-zinc-500';
    number.setAttribute('aria-hidden', 'true');
    number.textContent = String.fromCharCode(65 + index);
    const text = document.createElement('span');
    text.className = 'assessment-option-label';
    text.textContent = label;
    button.append(number, text);
    options.append(button);
  });
  heroDialogContent.querySelector('h2').focus();
}

function renderHeroAnswers() {
  renderHeroDialog('assessment-summary');
  const answers = heroDialogContent.querySelector('.js-component-hero-answers');
  heroQuestions.forEach((question, index) => {
    const row = document.createElement('div');
    row.className = 'answer';
    const label = document.createElement('dt');
    label.className = 'answer-question text-xs text-zinc-500';
    label.textContent = question.title;
    const value = document.createElement('dd');
    value.className = 'answer-value text-sm';
    value.textContent = heroAnswers[index];
    row.append(label, value);
    answers.append(row);
  });
}

document.addEventListener('click', (event) => {
  const button = event.target.closest('button');
  if (!button) return;

  if (button.matches('.js-component-hero-assessment-open')) {
    heroAnswers = [];
    heroStep = 0;
    openHeroDialog('assessment-intro', button);
  } else if (button.matches('.js-component-hero-assessment-begin, .js-component-hero-assessment-restart')) {
    heroStep = 0;
    renderHeroQuestion();
  } else if (button.matches('.js-component-hero-assessment-back')) {
    if (heroStep === 0) renderHeroDialog('assessment-intro');
    else {
      heroStep -= 1;
      renderHeroQuestion();
    }
  } else if (button.matches('.js-component-hero-answer')) {
    heroAnswers[heroStep] = button.dataset.answer;
    if (heroStep < heroQuestions.length - 1) {
      heroStep += 1;
      renderHeroQuestion();
    } else renderHeroAnswers();
  } else if (button.matches('.js-component-hero-product-option')) {
    selectHeroProduct(Number(button.dataset.product));
  } else if (button.matches('.js-component-hero-explorer-option')) {
    selectExplorerProduct(Number(button.dataset.product));
  } else if (button.matches('.js-component-hero-product-details, .js-component-hero-open-products')) {
    const selected = button.matches('.js-component-hero-product-details') ? heroProduct : 0;
    openHeroDialog('product-explorer', button);
    selectExplorerProduct(selected);
  } else if (button.matches('.js-component-hero-evidence-open')) {
    openHeroDialog('evidence-explorer', button);
  }
});

heroDialog.addEventListener('click', (event) => {
  if (event.target !== heroDialog) return;
  const bounds = heroDialog.getBoundingClientRect();
  const outside = event.clientX < bounds.left || event.clientX > bounds.right
    || event.clientY < bounds.top || event.clientY > bounds.bottom;
  if (outside) heroDialog.close();
});

heroDialog.addEventListener('close', () => {
  heroAnswers = [];
  heroStep = 0;
  heroDialogContent.replaceChildren();
  if (heroDialogTrigger?.isConnected) heroDialogTrigger.focus();
  heroDialogTrigger = null;
});

// Avoid changing the variant behind an open dialog; its buttons own keyboard focus until closed.
document.addEventListener('keydown', (event) => {
  if (heroDialog.open) event.stopImmediatePropagation();
});

new MutationObserver(() => { heroProduct = 0; }).observe(document.getElementById('stage'), { childList: true });
