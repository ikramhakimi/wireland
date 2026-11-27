<?php

/**
 * Component: Navbar quiz
 * Purpose: Focus header for the assessment flow.
 * Structure: Desktop: logo, back + progress pill, WhatsApp help.
 *            Mobile: back + progress pill, more button that opens a bottom drawer (Contact Support, Exit Assessment).
 * Data: back_href, step_label, percent (0–100), whatsapp_href, exit_href, exit_label (default Exit Assessment).
 *       Requires assets/js/drawer.js on the page. JS hooks (js-quiz-back, js-quiz-step-label, js-quiz-percent,
 *       js-quiz-ring, js-quiz-exit) let assets/js/assessment-quiz.js update progress and clear saved answers.
 */
$back_href     = $back_href ?? asset_url('assessment');
$step_label    = $step_label ?? '';
$percent       = max(0, min(100, (int) ($percent ?? 0)));
$whatsapp_href = $whatsapp_href ?? 'https://wa.me/601116741858';
$exit_href     = $exit_href ?? asset_url('');
$exit_label    = $exit_label ?? 'Exit Assessment';

$menu_id     = 'quiz-menu';
$menu_drawer = [
  'id'       => $menu_id,
  'title'    => 'How can we help?',
  'position' => 'bottom',
  'content'  => static function () use ($whatsapp_href, $exit_href, $exit_label): void {
    $support_button = [
      'label'  => 'Contact Support',
      'href'   => $whatsapp_href,
      'size'   => 'large',
      'color'  => 'default',
      'icon'   => 'whatsapp-line',
      'icon_position' => 'start',
      'class'  => 'quiz-menu-support w-full',
    ];
    $exit_button = [
      'label'   => $exit_label,
      'href'    => $exit_href,
      'size'    => 'large',
      'color'   => 'default',
      'class'   => 'quiz-menu-exit w-full',
      'js_hook' => 'js-quiz-exit',
    ];
    ?>
    <div class="quiz-menu-actions flex flex-col gap-3 pb-[env(safe-area-inset-bottom)]">
      <?php component('button', $support_button); ?>
      <?php component('button', $exit_button); ?>
      <p class="quiz-menu-note text-center text-xs color-muted">Exiting clears your answers.</p>
    </div>
    <?php
  },
];
?>
<header class="quiz-header sticky top-0 z-30 bg-zinc-100">
  <div class="quiz-header-container container grid grid-cols-[1fr_auto] items-center gap-2 h-18 px-4
    lg:grid-cols-[1fr_minmax(0,32rem)_1fr] lg:gap-3 lg:px-6">
    <a href="<?= asset_url(''); ?>" class="quiz-logo hidden items-center text-lg color-strong lg:flex"
      aria-label="RR HairClinic home">
      <span class="font-bold aspect-square w-9 flex-center border border-zinc-600 mr-2">RR</span>
      <span class="font-semibold">HairClinic</span>
    </a>

    <div class="quiz-status flex items-center gap-2 min-w-0">
      <a href="<?= e($back_href); ?>"
        class="quiz-back shrink-0 flex-center size-11 rounded-xl bg-zinc-200/70 color-strong transition-colors
          hover:bg-zinc-200
          focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-900
          js-quiz-back"
        aria-label="Go back">
        <?php svg('arrow-left-line', 'size-5'); ?>
      </a>
      <div class="quiz-progress flex flex-1 items-center justify-between gap-3 min-w-0 h-11 px-4 text-sm
        rounded-xl bg-zinc-200/70">
        <p class="quiz-progress-step truncate color-muted">
          <span class="js-quiz-step-label"><?= e($step_label); ?></span>
        </p>
        <div class="quiz-progress-meter shrink-0 flex items-center gap-2 color-strong">
          <svg viewBox="0 0 20 20" class="quiz-progress-ring size-5 -rotate-90" aria-hidden="true">
            <circle cx="10" cy="10" r="8" fill="none" stroke-width="2.5" class="stroke-zinc-300"></circle>
            <circle cx="10" cy="10" r="8" fill="none" stroke-width="2.5" stroke-linecap="round"
              pathLength="100" stroke-dasharray="100" stroke-dashoffset="<?= 100 - $percent; ?>"
              class="stroke-zinc-800 transition-[stroke-dashoffset] duration-300 ease-out
                motion-reduce:transition-none js-quiz-ring"></circle>
          </svg>
          <span class="quiz-progress-value">
            <span class="js-quiz-percent"><?= $percent; ?></span>% <span class="hidden sm:inline">complete</span>
          </span>
        </div>
      </div>
    </div>

    <a href="<?= e($whatsapp_href); ?>" target="_blank" rel="noopener"
      class="quiz-help hidden justify-self-end items-center gap-1.5 h-11 px-2 font-medium color-strong rounded-xl
        hover:bg-zinc-200/70
        focus-visible:outline-2 focus-visible:outline-zinc-900
        lg:flex">
      <?php svg('whatsapp-line', 'size-5'); ?>
      Help
      <span class="sr-only">(opens WhatsApp)</span>
    </a>

    <button type="button" aria-controls="<?= e($menu_id); ?>" aria-haspopup="dialog" aria-label="More options"
      class="quiz-more flex items-center justify-center size-11 rounded-xl bg-zinc-200/70 color-strong transition-colors
        hover:bg-zinc-200
        focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-900
        lg:hidden
        js-component-drawer-open">
      <?php svg('more-2-fill', 'size-5'); ?>
    </button>
  </div>
</header>
<?php component('drawer', $menu_drawer); ?>
