<?php

/**
 * Page: Assessment quiz — summary
 * Purpose: Results after sign-up: suggested basic products and a summary of the saved answers.
 * Structure: Quiz focus header (100%), intro, product cards, answers list, WhatsApp + restart actions.
 * Data: includes/assessment-quiz-data.php. assets/js/assessment-quiz.js fills answers and picks products
 *       from localStorage; it redirects to the register page until the user has signed up.
 */

$page_title       = 'Your Hair Assessment | RR HairClinic';
$page_description = 'A summary of your hair assessment answers and suggested products.';
$page_current     = 'assessment-quiz-summary';

require __DIR__ . '/../../includes/assessment-quiz-data.php';

$quiz_products = array_column(require __DIR__ . '/../../includes/dashboard-products-data.php', null, 'id');

$summary_whatsapp_text = 'Hi RR HairClinic, I have finished the hair assessment and would like to talk about my options.';
$summary_whatsapp_href = 'https://wa.me/601116741858?text=' . rawurlencode($summary_whatsapp_text);

$quiz_header = [
  'back_href'     => $quiz_routes['quiz'],
  'step_label'    => 'Assessment complete',
  'percent'       => 100,
  'whatsapp_href' => $quiz_whatsapp_href,
  'exit_href'     => $quiz_routes['exit'],
];
$summary_card = static fn (array $item): array => [
  'name'        => $item['name'],
  'href'        => asset_url('product/?id=' . rawurlencode($item['id'])),
  'pill'        => $item['category'] ?? '',
  'price'       => $item['price'],
  'base_price'  => $item['base_price'] ?? 0,
];
$results_whatsapp_button = [
  'label'         => 'Ask Our Team on WhatsApp',
  'href'          => $summary_whatsapp_href,
  'size'          => 'large',
  'color'         => 'primary',
  'icon'          => 'whatsapp-line',
  'icon_position' => 'start',
  'class'         => 'quiz-results-chat w-full sm:w-auto',
];
$results_restart_button = [
  'label'   => 'Start Again',
  'href'    => $quiz_routes['quiz'],
  'size'    => 'large',
  'color'   => 'secondary',
  'class'   => 'quiz-results-restart w-full sm:w-auto',
  'js_hook' => 'js-quiz-restart',
];
?>
<div class="quiz flex flex-col min-h-dvh bg-zinc-100 js-component-quiz" data-quiz-page="summary"
  data-quiz-config="<?= e(json_encode($quiz_config)); ?>">
  <?php component('navbar-quiz', $quiz_header); ?>

  <div class="quiz-body flex-1 px-4 pt-6 pb-16 sm:pt-12">
    <section class="quiz-results w-full max-w-3xl mx-auto" aria-labelledby="quiz-results-title">
      <header class="quiz-results-header max-w-lg">
        <p class="quiz-results-topic text-small font-medium color-muted">Your hair assessment</p>
        <h1 id="quiz-results-title" class="quiz-results-title mt-2 text-title-md font-semibold text-pretty
          color-strong">
          Here’s a summary of your answers
        </h1>
        <p class="quiz-results-description mt-3 text-small text-pretty color-default">
          These suggestions are based on your answers and are not a diagnosis. For treatments such as
          prescription medication, our team can review your answers with you first.
        </p>
      </header>

      <div class="quiz-results-products mt-10">
        <h2 class="quiz-results-subtitle text-title-sm font-semibold color-strong">Suggested for your routine</h2>
        <ul class="quiz-results-list grid grid-cols-2 gap-x-4 gap-y-2 mt-5 sm:grid-cols-3" role="list">
          <?php foreach (array_keys($quiz_recommendations) as $product_id): ?>
            <?php if (!isset($quiz_products[$product_id])) { continue; } ?>
            <li class="quiz-results-item grid js-quiz-product" data-product-id="<?= e($product_id); ?>" hidden>
              <?php component('card-product', $summary_card($quiz_products[$product_id])); ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="quiz-results-summary mt-10 rounded-xl border border-zinc-200 bg-white">
        <h2 class="quiz-results-subtitle px-5 pt-5 text-title-sm font-semibold color-strong">Your answers</h2>
        <dl class="quiz-results-answers divide-y divide-zinc-100 mt-3">
          <?php foreach ($quiz_questions as $question): ?>
            <?php $answer_labels = array_column($question['options'], 'label', 'value'); ?>
            <div class="quiz-results-answer grid gap-1 px-5 py-4 sm:grid-cols-2 sm:gap-6">
              <dt class="quiz-results-question text-small color-muted"><?= e($question['title']); ?></dt>
              <dd class="quiz-results-value text-small font-medium color-strong js-quiz-answer"
                data-question="<?= e($question['id']); ?>"
                data-labels="<?= e(json_encode($answer_labels)); ?>">Not sure</dd>
            </div>
          <?php endforeach; ?>
        </dl>
      </div>

      <div class="quiz-results-actions flex flex-col gap-3 mt-10 sm:flex-row">
        <?php component('button', $results_whatsapp_button); ?>
        <?php component('button', $results_restart_button); ?>
      </div>
    </section>
  </div>
</div>
<script src="<?= asset_url('assets/js/drawer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/drawer.js'); ?>" defer></script>
<script src="<?= asset_url('assets/js/assessment-quiz.js'); ?>?v=<?= filemtime(__DIR__ . '/../../assets/js/assessment-quiz.js'); ?>"
  defer></script>
