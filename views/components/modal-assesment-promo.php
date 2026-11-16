<?php

/**
 * Component: Assessment promo modal
 * Purpose: Show a hair loss promotion after thirty seconds of inactivity.
 * Structure: Native modal dialog, six radio choices, selection summary and placeholder CTA.
 * Data: Static hair loss options; assets from assets/images/bald.
 */
$hair_loss_options = [
  'temples'       => 'Temples',
  'temples-crown' => 'Temples & Crown',
  'moderate'      => 'Moderate',
  'extensive'     => 'Extensive',
  'patchy'        => 'Patchy',
  'complete'      => 'Complete',
];
?>
<dialog aria-labelledby="assessment-promo-title" aria-describedby="assessment-promo-description"
  class="modal-assesment-promo fixed inset-0 m-auto max-h-[calc(100dvh-2rem)] w-[calc(100%-2rem)]
    max-w-[500px] overflow-y-auto rounded-3xl border-0 bg-zinc-100 p-0 text-zinc-800
    backdrop:bg-zinc-950/40 backdrop:backdrop-blur-sm js-component-modal-assesment-promo">
  <div class="relative px-5 pb-4 pt-8 sm:px-11">
    <button type="button" aria-label="Close promotion"
      class="absolute right-5 top-5 flex size-10 items-center justify-center rounded-full bg-white
        focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-700
        js-component-modal-assesment-promo-close">
      <?php svg('close-line', 'size-6'); ?>
    </button>
    <h2 id="assessment-promo-title" class="mx-auto max-w-64 text-center text-4xl font-normal leading-tight">
      Save 50% on<br>hair loss plans
    </h2>
    <p id="assessment-promo-description" class="mt-2 text-center text-base leading-6">
      Let us know which image best matches your hair loss and check if you’re eligible for treatment
    </p>
    <fieldset class="mt-6">
      <legend class="mb-4 w-full text-center text-xl leading-7">
        Which image best matches your hair loss?
      </legend>
      <div class="grid grid-cols-3 gap-2.5">
        <?php foreach ($hair_loss_options as $hair_loss_value => $hair_loss_label): ?>
          <?php component('forms/choice', [
            'id'      => 'assessment-promo-' . $hair_loss_value,
            'type'    => 'radio',
            'name'    => 'assessment_promo_hair_loss',
            'value'   => $hair_loss_value,
            'label'   => $hair_loss_label,
            'image'   => asset_url('assets/images/bald/bald-' . $hair_loss_value . '.svg'),
            'js_hook' => 'js-component-modal-assesment-promo-option',
          ]); ?>
        <?php endforeach; ?>
      </div>
    </fieldset>
    <p aria-live="polite" aria-atomic="true"
      class="mt-4 flex min-h-14 items-center rounded-xl border border-zinc-200 bg-zinc-50 px-4 text-sm
        text-zinc-400 js-component-modal-assesment-promo-summary">
      Please select an option above first
    </p>
    <a href="#" aria-disabled="true" tabindex="-1"
      class="mx-auto mt-4 flex min-h-16 w-full max-w-90 items-center justify-center rounded-full
        bg-zinc-700 px-6 py-4 text-center font-semibold text-white
        aria-disabled:pointer-events-none aria-disabled:opacity-45
        focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-700
        js-component-modal-assesment-promo-action">
      Check if I qualify
    </a>
    <button type="button"
      class="mx-auto mt-3 block p-1 text-sm underline underline-offset-2
        js-component-modal-assesment-promo-close">
      Continue exploring
    </button>
    <p class="-mx-2 mt-4 text-center text-xs leading-[18px]">
      Your details help us recommend the right treatment for you — based on how your body works.
      By entering I agree to the <a href="#" class="underline underline-offset-2">Terms and Conditions</a>
    </p>
  </div>
</dialog>
