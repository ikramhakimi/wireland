/**
 * Workflow Desk: pipeline stage filter, case selection with a preview, and search across every stage.
 * From xl the preview sits beside the list; below xl it opens as a full-screen sheet with Back to List
 * (Escape also closes it, and focus returns to the case row). No other keyboard shortcuts.
 * Hooks: .js-component-workflow-desk[data-stage][data-selected], .js-component-workflow-desk-stage[data-stage],
 *        .js-component-workflow-desk-case[data-stage][data-search] > .js-component-case-row[data-case],
 *        .js-component-case-preview[data-case] with .js-component-case-preview-back,
 *        .js-component-workflow-desk-search, -list, -list-title, -list-count, -empty[data-stage], -pipeline,
 *        -preview, -preview-empty.
 */
document.addEventListener('DOMContentLoaded', () => {
  const desk = document.querySelector('.js-component-workflow-desk');
  if (!desk) {
    return;
  }

  const hook         = (name) => desk.querySelector(`.js-component-workflow-desk-${name}`);
  const stages       = [...desk.querySelectorAll('.js-component-workflow-desk-stage')];
  const items        = [...desk.querySelectorAll('.js-component-workflow-desk-case')];
  const previews     = [...desk.querySelectorAll('.js-component-case-preview')];
  const empties      = [...desk.querySelectorAll('.js-component-workflow-desk-empty')];
  const search       = hook('search');
  const input        = search.querySelector('input');
  const list         = hook('list');
  const listTitle    = hook('list-title');
  const listCount    = hook('list-count');
  const pipeline     = hook('pipeline');
  const preview      = hook('preview');
  const previewEmpty = hook('preview-empty');
  const wide         = window.matchMedia('(min-width: 80rem)');

  const state = {
    stage:    desk.dataset.stage,
    query:    '',
    selected: desk.dataset.selected,
  };

  const rowOf        = (item) => item.querySelector('.js-component-case-row');
  const visibleItems = () => items.filter((item) => !item.hidden);
  const stageLabel   = (key) => stages.find((stage) => stage.dataset.stage === key)
    .querySelector('.workflow-desk-stage-label').textContent.trim();

  const isSheetOpen = () => preview.dataset.sheet === 'open';

  const setSheet = (open) => {
    const show = open && !wide.matches;
    preview.dataset.sheet = show ? 'open' : 'closed';
    document.body.classList.toggle('overflow-hidden', show);
    list.inert     = show;
    pipeline.inert = show;
  };

  const select = (id) => {
    state.selected = id;
    items.forEach((item) => {
      rowOf(item).setAttribute('aria-current', rowOf(item).dataset.case === id ? 'true' : 'false');
    });
    previews.forEach((article) => {
      article.hidden = article.dataset.case !== id;
    });
    previewEmpty.hidden = id !== '';
    preview.scrollTop = 0;
  };

  const openSheet = (id) => {
    select(id);
    setSheet(true);
    if (!isSheetOpen()) {
      return;
    }

    const article = previews.find((item) => item.dataset.case === id);
    article?.querySelector('.js-component-case-preview-back')?.focus();
  };

  const closeSheet = () => {
    if (!isSheetOpen()) {
      return;
    }

    setSheet(false);
    const current = items.find((item) => rowOf(item).dataset.case === state.selected);
    if (current) {
      rowOf(current).focus();
      current.scrollIntoView({ block: 'nearest' });
    }
  };

  const render = () => {
    const searching = state.query !== '';
    items.forEach((item) => {
      item.hidden = searching ? !item.dataset.search.includes(state.query) : item.dataset.stage !== state.stage;
    });
    stages.forEach((stage) => {
      stage.setAttribute('aria-pressed', !searching && stage.dataset.stage === state.stage ? 'true' : 'false');
    });

    const visible = visibleItems();
    listTitle.textContent = searching ? 'Search Results' : stageLabel(state.stage);
    listCount.textContent = `${visible.length} ${visible.length === 1 ? 'case' : 'cases'}`;
    empties.forEach((empty) => {
      empty.hidden = visible.length > 0 || empty.dataset.stage !== (searching ? 'search' : state.stage);
    });

    if (!visible.some((item) => rowOf(item).dataset.case === state.selected)) {
      select(visible[0] ? rowOf(visible[0]).dataset.case : '');
    }
  };

  stages.forEach((stage) => {
    stage.addEventListener('click', () => {
      state.stage = stage.dataset.stage;
      state.query = '';
      input.value = '';
      render();
    });
  });

  items.forEach((item) => {
    rowOf(item).addEventListener('click', () => openSheet(rowOf(item).dataset.case));
  });

  desk.querySelectorAll('.js-component-case-preview-back').forEach((button) => {
    button.addEventListener('click', closeSheet);
  });

  preview.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closeSheet();
    }
  });

  search.addEventListener('submit', (event) => event.preventDefault());
  input.addEventListener('input', () => {
    state.query = input.value.trim().toLowerCase();
    render();
  });

  wide.addEventListener('change', () => setSheet(false));

  render();
  select(state.selected);
  setSheet(false);
});
