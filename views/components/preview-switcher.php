<?php

/**
 * Component: Preview switcher (prototype only)
 * Purpose: Lets reviewers switch a mockup page between its states without editing URLs.
 * Structure: Floating <details> at the bottom-left; the summary shows the current state and the panel lists
 *            every state as a link to the same page with ?state=.
 * Data: group (key in includes/preview-states.php). Render once per page, after the page content.
 */
$group  = $group ?? '';
$config = preview_groups()[$group] ?? null;

if ($config === null || ($config['states'] ?? []) === []) {
  return;
}

$current       = preview_state($group);
$page_path     = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
$current_label = $config['states'][$current]['label'] ?? '';
?>
<details class="preview-switcher group fixed bottom-4 left-4 z-50">
  <summary class="preview-switcher-toggle flex items-center gap-2 py-2 pl-3 pr-2.5 rounded-full bg-zinc-900
    text-caption font-medium shadow-lg ring-1 ring-white/10 color-invert-strong list-none cursor-pointer
    hover:bg-zinc-800">
    <span class="preview-switcher-dot size-2 rounded-full bg-emerald-400" aria-hidden="true"></span>
    <span class="preview-switcher-label">
      <span class="text-zinc-400">Preview:</span> <?= e($current_label); ?>
    </span>
    <?php svg('arrow-down-s-line', 'size-4 text-zinc-400 rotate-180 transition-transform group-open:rotate-0'); ?>
  </summary>
  <div class="preview-switcher-panel absolute bottom-full left-0 w-64 max-w-[calc(100vw-2rem)] mb-2 p-1.5
    rounded-2xl bg-zinc-900 shadow-xl ring-1 ring-white/10">
    <p class="preview-switcher-title px-2.5 pt-1.5 pb-2 text-caption text-zinc-400">
      Prototype · <?= e($config['title'] ?? 'Page state'); ?>
    </p>
    <ul class="preview-switcher-list grid gap-0.5" role="list">
      <?php foreach ($config['states'] as $key => $state): ?>
        <?php $is_current = $key === $current; ?>
        <li class="preview-switcher-item">
          <a href="<?= e($page_path . preview_query($group, $key)); ?>"
            class="preview-switcher-link flex items-center justify-between gap-3 px-2.5 py-2 rounded-xl
              <?= $is_current ? 'bg-white/10' : 'hover:bg-white/5'; ?>"
            <?= $is_current ? 'aria-current="page"' : ''; ?>>
            <span class="preview-switcher-text">
              <span class="block text-small font-medium color-invert-strong"><?= e($state['label']); ?></span>
              <?php if (($state['text'] ?? '') !== ''): ?>
                <span class="block text-caption text-zinc-400"><?= e($state['text']); ?></span>
              <?php endif; ?>
            </span>
            <?php if ($is_current): ?>
              <?php svg('checkbox-circle-line', 'size-4 shrink-0 text-emerald-400'); ?>
            <?php endif; ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</details>
