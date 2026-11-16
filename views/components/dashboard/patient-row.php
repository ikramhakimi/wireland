<?php

/**
 * Component: Patient directory row
 * Purpose: Three-column Triage record with patient identity, care and existing actions.
 * Structure: Mobile card and desktop row; row_order keeps the ungrouped directory order stable.
 * Data: patient (directory record), row_order (index within the current page).
 */
$patient         = $patient ?? [];
$row_order       = $row_order ?? 0;
$follow_up_color = $patient['next_follow_up'] === null ? 'color-muted'
  : ($patient['follow_up_status'] === 'Overdue' ? 'color-negative' : 'color-primary');

?>
<li data-follow-up="<?= e($patient['follow_up_status']); ?>" data-order="<?= e($row_order); ?>"
  class="patient-row min-w-0 mb-3 border-dashed border-zinc-200
    sm:mb-0 sm:py-1 sm:border-t
    js-component-patients-row">
  <div class="patient-content grid grid-cols-2 gap-4 min-w-0 p-4 rounded-lg bg-white
    hover:bg-white focus-within:bg-white
    sm:grid-cols-1 sm:gap-0 sm:p-0 sm:bg-transparent sm:hover:bg-white sm:focus-within:bg-white
    @3xl:grid-cols-[50%_minmax(0,1fr)_11rem]">
    <div class="patient-identity col-span-2 min-w-0 font-normal
      sm:col-span-1 sm:p-4">
      <div class="patient-profile flex flex-row-reverse items-start gap-4 min-w-0
        sm:flex-row">
        <span aria-hidden="true"
          class="patient-avatar flex shrink-0 items-center justify-center size-12 text-caption font-medium rounded-lg border border-zinc-300 bg-zinc-200 color-strong"><?= e(implode('', array_map(
            static fn (string $part): string => substr($part, 0, 1),
            array_slice(explode(' ', $patient['name']), 0, 2)
          ))); ?></span>
        <div class="patient-heading flex-1 min-w-0 sm:flex-none">
          <p class="patient-reference mb-1 text-caption color-muted">
            <?= e($patient['id']); ?> · <span class="sr-only">Assessment: </span><?= e($patient['assessment']); ?>
          </p>
          <h3 class="patient-name text-small font-medium color-strong wrap-anywhere"><?= e($patient['name']); ?></h3>
          <p class="patient-contact flex flex-wrap gap-x-1 mt-2 text-caption color-muted">
            <span class="patient-phone"><?= e($patient['phone']); ?></span>
            <span aria-hidden="true" class="patient-separator">·</span>
            <span class="patient-email wrap-anywhere"><?= e($patient['email']); ?></span>
          </p>
        </div>
      </div>
    </div>
    <div class="patient-care min-w-0 sm:p-4">
      <p class="patient-label text-caption color-muted">Next Follow-up</p>
      <p class="patient-schedule flex flex-wrap items-baseline gap-x-1 mt-1 text-small leading-tight
        sm:leading-normal">
        <span class="patient-date font-medium tabular-nums <?= e($follow_up_color); ?>"><?= $patient['next_follow_up'] !== null
          ? e((new DateTimeImmutable($patient['next_follow_up']))->format('j M Y')) : 'Not scheduled'; ?></span>
      </p>
      <p class="patient-activity hidden flex-wrap items-center gap-2 mt-2 text-caption color-muted
        sm:flex">
        <span class="patient-purchases">Purchase <strong class="patient-count font-medium tabular-nums color-strong"><?= e($patient['products_purchased']); ?></strong></span>
        <?php if ($patient['clinic_visits'] > 0): ?>
          <span aria-hidden="true" class="patient-separator">|</span>
          <span class="patient-visits">Visit <strong class="patient-count font-medium tabular-nums color-strong"><?= e($patient['clinic_visits']); ?></strong></span>
        <?php endif; ?>
      </p>
    </div>
    <div class="patient-controls self-end min-w-0 sm:self-auto sm:p-4">
      <div class="patient-actions flex flex-wrap items-center justify-end gap-2
        sm:justify-start
        @3xl:justify-end">
        <div class="patient-preview hidden sm:block">
          <?php component('tooltip', [
            'id'              => 'patient-tooltip-view-' . $patient['id'],
            'label'           => 'View Patient',
            'text'            => 'View Patient',
            'trigger_content' => static function () use ($patient): void {
              component('button', [
                'label'         => 'View Patient',
                'size'          => 'small',
                'variant'       => 'icon-only',
                'icon'          => 'eye-line',
                'href'          => asset_url('dashboard/patient/') . '?id=' . rawurlencode($patient['id']),
                'color'         => 'secondary',
                'aria_label'    => 'View Patient: ' . $patient['name'],
                'aria_controls' => 'preview-' . $patient['id'],
                'js_hook'       => 'js-component-patients-preview',
              ]);
            },
          ]); ?>
        </div>
        <?php component('tooltip', [
          'id'              => 'patient-tooltip-edit-' . $patient['id'],
          'label'           => 'Edit Patient',
          'text'            => 'Edit Patient',
          'trigger_content' => static function () use ($patient): void {
            component('button', [
              'label'      => 'Edit Patient',
              'element'    => 'button',
              'size'       => 'small',
              'variant'    => 'icon-only',
              'icon'       => 'edit-line',
              'color'      => 'secondary',
              'aria_label' => 'Edit Patient: ' . $patient['name'],
            ]);
          },
        ]); ?>
        <?php component('tooltip', [
          'id'              => 'patient-tooltip-more-' . $patient['id'],
          'label'           => 'More Actions',
          'text'            => 'More Actions',
          'trigger_content' => static function () use ($patient): void {
            component('dropdown', [
              'id'         => 'patient-actions-' . $patient['id'],
              'label'      => 'More Actions',
              'trigger'    => 'icon',
              'size'       => 'small',
              'align'      => 'end',
              'aria_label' => 'More Actions: ' . $patient['name'],
              'groups'     => [
                ['items' => [
                  ['label' => 'Schedule Follow-up'],
                  ['label' => 'Archive Patient'],
                ]],
                ['items' => [
                  ['label' => 'Delete', 'destructive' => true],
                ]],
              ],
            ]);
          },
        ]); ?>
      </div>
    </div>
  </div>
</li>
