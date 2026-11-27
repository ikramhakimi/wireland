<?php

$page_title       = 'UI Design Guideline';
$page_description = 'Shared visual foundations and components for the website and dashboards.';
$page_current     = 'design';

// Section order and files come from the registry; each section lives in views/components/design/sections/.
$design_sections = require __DIR__ . '/../../includes/design-sections.php';

?>
<div class="design-page font-sans color-default">
  <div class="design-container">
    <header class="design-header max-w-3xl">
      <p class="design-eyebrow text-sm font-medium color-muted">Wireland / Design reference</p>
      <h1 class="design-title mt-4 text-4xl font-semibold leading-tight text-pretty color-strong sm:text-5xl">
        One visual language.<br>Every experience.
      </h1>
      <p class="design-description mt-5 text-base leading-7 text-pretty">
        Shared foundations and component examples for the website, Patient, Doctor, and Admin dashboards.
        This is the starting reference; additional variants and interactions will be documented as they are defined.
      </p>
    </header>

    <?php foreach ($design_sections as $design_group): ?>
      <?php foreach ($design_group as $design_section): ?>
        <?php if ($design_section['file'] !== null): ?>
          <?php component('components/design/sections/' . $design_section['file']); ?>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </div>
</div>
