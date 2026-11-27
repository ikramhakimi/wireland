<?php

/**
 * Component: Assessment action
 * Purpose: Claim a queue item or open its review.
 * Structure: Claim form with token and record ID, or link to the assessment.
 * Data: item (assessment-item.php), token and action_url (queue POST target).
 */
$name = $item['patient']['name'];

if ($item['action'] === 'claim'):
  ?>
  <form action="<?= e($action_url); ?>" method="post" class="assessment-claim">
    <input type="hidden" name="token" value="<?= e($token); ?>">
    <input type="hidden" name="action" value="claim">
    <input type="hidden" name="assessment_id" value="<?= e($item['record']['id']); ?>">
    <?php component('button', [
      'label'      => 'Claim',
      'element'    => 'button',
      'type'       => 'submit',
      'size'       => 'small',
      'color'      => 'primary',
      'aria_label' => 'Claim assessment for ' . $name,
    ]); ?>
  </form>
<?php else:
  $is_review = $item['action'] === 'review';
  component('button', [
    'label'      => $is_review ? 'Review' : 'View',
    'href'       => $item['review_href'],
    'size'       => 'small',
    'color'      => $is_review ? 'primary' : 'default',
    'aria_label' => ($is_review ? 'Review assessment for ' : 'View assessment for ') . $name,
  ]);
endif;
