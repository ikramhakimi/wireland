<?php

$page_title       = 'Assessment Workflow';
$page_description = 'Shared workflow reference for product owners, developers and doctors.';
$page_current     = 'assessment-workflow';

$workflow_sections = [
  [
    'id'          => 'scope',
    'title'       => '01 · Purpose and Scope',
    'description' => 'Agreed requirements from the product brief.',
    'notes'       => [
      'Patients submit a frontpage quiz about their condition. Doctors review the assessment and decide on an appropriate care plan.',
      'A care plan may include prescribed products or basic products only, depending on the doctor’s review. A prescription does not require the patient to buy the prescribed items.',
      'Follow-up must support patients who buy prescribed products and patients who buy basic products without a prescription.',
      'This page documents the intended workflow. It does not submit assessments, issue prescriptions, track orders or schedule reminders.',
    ],
  ],
  [
    'id'          => 'workflow',
    'title'       => '02 · Doctor Workflow',
    'description' => 'Proposed sequence for discussion with doctors and developers.',
    'columns'     => ['Step', 'Owner and Action', 'Outcome / Next Step'],
    'rows'        => [
      ['1. Submit quiz', 'Patient submits their answers about their condition.', 'Create an assessment linked to the patient; add Review Assessment to the doctor queue.'],
      ['2. Review assessment', 'Assigned doctor reviews answers and any available supporting information.', 'Request missing information, or continue to a care plan.'],
      ['3. Request information', 'Doctor records what is needed; patient provides a response.', 'Keep the case awaiting information until a response is available for review.'],
      ['4. Record care plan', 'Doctor records their review and chooses prescription, basic products only, or consultation / no product.', 'Save the decision and next action. Only the doctor decides whether a prescription is appropriate.'],
      ['5. Track purchase', 'Link the patient’s qualifying order to the care plan where applicable.', 'Record prescribed products purchased or basic products purchased. An unpurchased prescription remains separate.'],
      ['6. Set follow-up', 'Apply the configured timing rule; allow the doctor to set a patient-specific date.', 'Assign a follow-up owner, due date and reminder date.'],
      ['7. Review progress', 'Doctor records the patient response, progress and any concerns.', 'Continue or adjust the care plan, arrange another follow-up, or close the case with a reason.'],
    ],
  ],
  [
    'id'          => 'states',
    'title'       => '03 · Separate Statuses',
    'description' => 'Assessment, prescription, purchase and follow-up represent different events.',
    'columns'     => ['Record', 'Proposed Statuses', 'Rule'],
    'rows'        => [
      ['Assessment', 'Submitted → In Review → Awaiting Information → Reviewed', 'Awaiting Information returns to In Review when a response arrives. Reviewed means a doctor recorded a decision, not that a purchase happened.'],
      ['Care plan', 'Prescription / Basic Products Only / Consultation / No Product', 'These are decision types, not purchase statuses. Record the reviewing doctor and decision date.'],
      ['Prescription', 'Draft → Issued; Cancelled where applicable', 'Issuing requires a doctor action. Buying a basic product must never mark a prescription as purchased or fulfilled.'],
      ['Purchase', 'No Qualifying Purchase / Prescribed Products Purchased / Basic Products Purchased', 'Derive from linked order items and the agreed qualifying order status. Mixed and partial orders need item-level matching.'],
      ['Follow-up', 'Unscheduled → Scheduled → Due → Completed; Cancelled where applicable', 'Overdue means the due date has passed and the follow-up is still open. Another follow-up is a new linked record.'],
    ],
  ],
  [
    'id'          => 'tasks',
    'title'       => '04 · Doctor Tasklist',
    'description' => 'Each task needs a patient, case link, owner, next action and due date where applicable.',
    'columns'     => ['Trigger', 'Next Action', 'Completion Rule'],
    'rows'        => [
      ['New assessment', 'Review Assessment', 'Doctor starts reviewing the case.'],
      ['Missing information', 'Request Information', 'Record the request; show Awaiting Patient Response rather than a completed review.'],
      ['Patient responds', 'Review Patient Response', 'Doctor reviews the new information and records the next decision.'],
      ['Review ready', 'Complete Care Plan', 'Save the doctor’s decision and any required prescription.'],
      ['Qualifying purchase', 'Set Follow-up', 'Save an assigned follow-up with a due date, or confirm the automatically proposed schedule.'],
      ['Reminder date reached', 'Prepare Follow-up', 'Make the upcoming follow-up visible to its assigned doctor. Preparing does not complete it.'],
      ['Due date reached', 'Review Progress', 'Record the outcome and next action. Keep unanswered cases open with a recorded contact attempt.'],
      ['Review completed', 'Continue Plan / Adjust Plan / Close Case', 'Record the decision; create the next follow-up if required.'],
    ],
    'notes'       => [
      'Proposed queue order: overdue follow-ups, due today, upcoming reminders, then assessments awaiting review. Clinical priority rules require doctor agreement.',
      'Waiting for a purchase must remain distinct from a doctor task. The no-purchase contact policy is still to be decided.',
    ],
  ],
  [
    'id'          => 'purchase-paths',
    'title'       => '05 · Purchase and Follow-up Paths',
    'description' => 'Both purchase paths can lead to follow-up without making a prescription mandatory.',
    'columns'     => ['Path', 'Linking Rule', 'Follow-up Action'],
    'rows'        => [
      ['Prescribed products purchased', 'Link patient, assessment, care plan, prescription and matching order items.', 'Use the prescribed-product timing rule.'],
      ['Basic products purchased without prescription', 'Link patient and order; link an assessment and care plan when available.', 'Use the basic-product timing rule. An assessment must not be invented to fill a missing link.'],
      ['Basic products purchased after a prescription was issued', 'Keep the prescription record separate; classify the purchased items as basic products.', 'Use the agreed basic-product rule; show the doctor what was actually purchased.'],
      ['No purchase', 'Keep the assessment and care plan available.', 'Do not start a purchase-triggered schedule. Manual follow-up and no-purchase outreach need an agreed policy.'],
      ['Repeat, mixed or partial purchase', 'Match items and retain links to previous follow-ups.', 'Check for an existing open follow-up before creating another; the grouping policy is pending.'],
      ['Cancelled or refunded order', 'Retain the order link and history.', 'Flag the existing follow-up for review. Do not silently complete or delete it.'],
    ],
  ],
  [
    'id'          => 'settings',
    'title'       => '06 · Follow-up Settings',
    'description' => 'Proposed configuration. No clinical timing defaults have been agreed.',
    'columns'     => ['Setting', 'Purpose', 'Decision / Constraint'],
    'rows'        => [
      ['Prescribed-product interval', 'Days from the agreed start event to the follow-up due date.', 'Doctor-approved value required; may need to vary by care plan or product.'],
      ['Basic-product interval', 'Separate follow-up timing for purchases without prescription.', 'Doctor-approved value required.'],
      ['Start event', 'Choose purchase, delivery or confirmed start of use.', 'Select an event that the system can reliably capture; do not substitute a missing event silently.'],
      ['Reminder lead time', 'Number of days before the due date that a doctor preparation task appears.', 'Use a non-negative whole number that does not place the reminder before the start event.'],
      ['Assigned doctor', 'Owns the follow-up and its tasks.', 'Agree a fallback queue when no doctor is assigned or the owner is unavailable.'],
      ['Patient-specific date', 'Allows the doctor to change the schedule for an individual case.', 'Record who changed it, when and why; recalculate the reminder date.'],
      ['Changes to defaults', 'Controls whether new settings affect existing schedules.', 'Proposed: apply to new follow-ups only; explicitly review changes to existing dates.'],
    ],
    'notes'       => [
      'Due date = agreed start date + follow-up interval.',
      'Reminder date = due date − reminder lead time.',
      'These reminders are internal doctor tasks. Patient email, SMS or WhatsApp reminders are not defined in this workflow.',
      'Agree the clinic timezone and date boundaries before implementing due and overdue calculations.',
    ],
  ],
  [
    'id'          => 'records',
    'title'       => '07 · Developer Reference',
    'description' => 'Proposed record boundaries and implementation requirements.',
    'columns'     => ['Record', 'Minimum Information'],
    'rows'        => [
      ['Assessment', 'Patient reference, quiz version, submitted answers, submission date, status, assigned doctor and review history.'],
      ['Care plan and prescription', 'Assessment reference, doctor decision, notes, author and timestamps; prescribed items and issue status where applicable.'],
      ['Purchase link', 'Patient, order and item references; qualifying event timestamp; optional assessment, care plan and prescription references.'],
      ['Follow-up', 'Patient, purchase source, optional assessment / prescription, owner, timing rule snapshot, start date, due date, reminder date, status and outcome.'],
      ['Task and activity history', 'Case reference, action, owner, due date, completion event and dated actor history.'],
    ],
    'notes'       => [
      'Process repeated order events safely: the same qualifying event must not create duplicate tasks or follow-ups.',
      'Keep the doctor’s decision separate from order events. Restrict prescribing and clinical review actions to authorised clinical users.',
      'Preserve previous care plans and follow-up outcomes when a plan changes. Record contact attempts without marking the review completed.',
      'Current dashboard patient records are demos. Production quiz, prescribing, order events, access controls and reminder scheduling still need integration.',
    ],
  ],
  [
    'id'          => 'decisions',
    'title'       => '08 · Decisions to Confirm',
    'description' => 'Resolve these together before implementing automated behaviour.',
    'columns'     => ['Reference', 'Decision', 'Owner'],
    'rows'        => [
      ['D01', 'Which quiz fields and supporting information must a doctor review before recording a care plan?', 'Doctors + Product'],
      ['D02', 'Which order status qualifies, and does timing start at purchase, delivery or confirmed use?', 'Product + Doctors + Developer'],
      ['D03', 'What intervals apply to prescribed and basic products, and can they vary by product or plan?', 'Doctors'],
      ['D04', 'How many days before follow-up should the internal reminder appear?', 'Doctors + Operations'],
      ['D05', 'Who owns basic-product follow-ups when there is no assessment or assigned doctor?', 'Doctors + Operations'],
      ['D06', 'Should repeat, mixed and partial orders create separate follow-ups or update an existing schedule?', 'Product + Doctors'],
      ['D07', 'What happens after no purchase, an unanswered follow-up, cancellation or refund?', 'Product + Doctors + Operations'],
      ['D08', 'Who can issue prescriptions, change dates, reassign tasks and close cases? Which clinic timezone applies?', 'Product + Doctors + Developer'],
    ],
  ],
];

$decision_targets = [
  'D01' => 'workflow',
  'D02' => 'purchase-paths',
  'D03' => 'settings',
  'D04' => 'settings',
  'D05' => 'tasks',
  'D06' => 'purchase-paths',
  'D07' => 'purchase-paths',
  'D08' => 'records',
];

$owner_roles = [
  'Product'    => ['label' => 'Designer', 'class' => 'text-pink-500'],
  'Doctors'    => ['label' => 'Doctor', 'class' => 'text-blue-500'],
  'Operations' => ['label' => 'Operation', 'class' => 'text-amber-500'],
  'Developer'  => ['label' => 'Developer', 'class' => 'text-violet-500'],
];

$render_reference = static function (string $reference) use ($decision_targets): void {
  ?>
  <a href="#<?= e($decision_targets[$reference]); ?>"
    class="reference-link font-medium underline underline-offset-4
      hover:text-zinc-800 focus-visible:outline-2 focus-visible:outline-blue-800"><?= e($reference); ?></a>
  <?php
};

$render_owner_roles = static function (string $owners) use ($owner_roles): void {
  ?>
  <span class="reference-owners inline-flex flex-wrap items-baseline gap-x-2 gap-y-1">
    <?php foreach (explode(' + ', $owners) as $owner_index => $owner): ?>
      <?php if ($owner_index > 0): ?>
        <span class="reference-separator">+</span>
      <?php endif; ?>
      <span class="reference-role font-medium <?= e($owner_roles[$owner]['class']); ?>"><?= e($owner_roles[$owner]['label']); ?></span>
    <?php endforeach; ?>
  </span>
  <?php
};

// Editorial emphasis is limited to selected phrases; all text remains escaped when rendered.
$important_phrases = [
  'Doctors review the assessment',
  'does not require the patient to buy the prescribed items',
  'basic products without a prescription',
  'does not submit assessments, issue prescriptions, track orders or schedule reminders',
  'Review Assessment',
  'Request missing information',
  'Only the doctor decides',
  'unpurchased prescription remains separate',
  'owner, due date and reminder date',
  'close the case with a reason',
  'not that a purchase happened',
  'not purchase statuses',
  'must never mark a prescription as purchased or fulfilled',
  'item-level matching',
  'follow-up is still open',
  'Awaiting Patient Response',
  'Review Patient Response',
  'Complete Care Plan',
  'Set Follow-up',
  'Prepare Follow-up',
  'Review Progress',
  'Keep unanswered cases open',
  'overdue follow-ups',
  'due today',
  'must remain distinct from a doctor task',
  'prescribed-product timing rule',
  'basic-product timing rule',
  'must not be invented',
  'Keep the prescription record separate',
  'Do not start a purchase-triggered schedule',
  'existing open follow-up',
  'Do not silently complete or delete it',
  'Doctor-approved value required',
  'purchase, delivery or confirmed start of use',
  'non-negative whole number',
  'fallback queue',
  'recalculate the reminder date',
  'apply to new follow-ups only',
  'Due date = agreed start date + follow-up interval',
  'Reminder date = due date − reminder lead time',
  'internal doctor tasks',
  'clinic timezone',
  'quiz version',
  'doctor decision',
  'qualifying event timestamp',
  'timing rule snapshot',
  'dated actor history',
  'must not create duplicate tasks or follow-ups',
  'authorised clinical users',
  'Preserve previous care plans and follow-up outcomes',
  'still need integration',
  'quiz fields and supporting information',
  'Which order status qualifies',
  'What intervals',
  'How many days before follow-up',
  'Who owns basic-product follow-ups',
  'repeat, mixed and partial orders',
  'no purchase, an unanswered follow-up, cancellation or refund',
  'issue prescriptions, change dates, reassign tasks and close cases',
];
$emphasis_pattern = '/(' . implode('|', array_map(static function (string $phrase): string {
  return preg_quote($phrase, '/');
}, $important_phrases)) . ')/iu';

$render_content = static function (string $text) use ($emphasis_pattern): void {
  foreach (preg_split($emphasis_pattern, $text, -1, PREG_SPLIT_DELIM_CAPTURE) as $index => $part) {
    if ($index % 2 === 1) {
      ?><strong class="reference-emphasis px-1 font-medium rounded bg-amber-50 text-zinc-800"><?= e($part); ?></strong><?php
    } else {
      echo e($part);
    }
  }
};

$workflow_cards = [];
foreach ($workflow_sections as $workflow_section) {
  $workflow_cards[] = [
    'title'         => explode(' · ', $workflow_section['title'], 2)[1],
    'header_number' => explode(' · ', $workflow_section['title'], 2)[0],
    'description'   => $workflow_section['description'],
    'actions_flush' => true,
    'actions_border' => false,
    'actions'       => static function () use ($workflow_section): void {
      component('dashboard/workflow-review', [
        'reference' => $workflow_section['id'] . '-review',
        'label'     => $workflow_section['title'],
        'question'  => $workflow_section['description'],
      ]);
    },
    'content'       => static function () use ($workflow_section, $render_reference, $render_owner_roles, $render_content): void {
      ?>
      <?php if (isset($workflow_section['columns'])): ?>
        <div class="reference-records grid min-w-0 gap-6 md:hidden">
          <?php foreach ($workflow_section['rows'] as $row): ?>
            <article class="reference-record grid min-w-0 gap-3 wrap-anywhere">
              <h4 class="reference-title text-sm font-medium text-zinc-800">
                <?php if ($workflow_section['id'] === 'decisions'): ?>
                  <?php $render_reference($row[0]); ?>
                <?php else: ?>
                  <?= e($row[0]); ?>
                <?php endif; ?>
              </h4>
              <dl class="reference-details grid gap-3">
                <?php foreach (array_slice($row, 1, null, true) as $column_index => $cell): ?>
                  <div class="reference-field grid gap-1">
                    <dt class="reference-label text-xs font-medium text-zinc-500">
                      <?= e($workflow_section['columns'][$column_index]); ?>
                    </dt>
                    <dd class="reference-value text-sm leading-relaxed">
                      <?php if ($workflow_section['columns'][$column_index] === 'Owner'): ?>
                        <?php $render_owner_roles($cell); ?>
                      <?php else: ?>
                        <?php $render_content($cell); ?>
                      <?php endif; ?>
                    </dd>
                  </div>
                <?php endforeach; ?>
              </dl>
            </article>
          <?php endforeach; ?>
        </div>
        <div class="reference-table hidden min-w-0 md:block">
          <table class="reference-grid w-full table-fixed text-left text-sm text-pretty wrap-anywhere">
            <caption class="reference-caption sr-only"><?= e($workflow_section['title']); ?></caption>
            <thead class="reference-head border-b border-zinc-200">
              <tr class="reference-row">
                <?php foreach ($workflow_section['columns'] as $column): ?>
                  <th scope="col" class="reference-heading px-3 py-3 text-left align-top font-medium text-pretty text-zinc-800
                    first:ps-0 last:pe-0"><?= e($column); ?></th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody class="reference-body divide-y divide-zinc-100">
              <?php foreach ($workflow_section['rows'] as $row): ?>
                <tr class="reference-row">
                  <th scope="row" class="reference-label py-3 pe-3 text-left align-top font-medium text-pretty text-zinc-800">
                    <?php if ($workflow_section['id'] === 'decisions'): ?>
                      <?php $render_reference($row[0]); ?>
                    <?php else: ?>
                      <?= e($row[0]); ?>
                    <?php endif; ?>
                  </th>
                  <?php foreach (array_slice($row, 1, null, true) as $column_index => $cell): ?>
                    <td class="reference-value px-3 py-3 text-left align-top leading-relaxed text-pretty
                      last:pe-0">
                      <?php if ($workflow_section['columns'][$column_index] === 'Owner'): ?>
                        <?php $render_owner_roles($cell); ?>
                      <?php else: ?>
                        <?php $render_content($cell); ?>
                      <?php endif; ?>
                    </td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
      <?php if (isset($workflow_section['notes'])): ?>
        <ul class="reference-notes grid gap-3 ps-5 leading-relaxed list-disc <?= isset($workflow_section['columns']) ? 'mt-8' : ''; ?>">
          <?php foreach ($workflow_section['notes'] as $note): ?>
            <li class="reference-note"><?php $render_content($note); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <?php
    },
  ];
}

?>
<section class="section min-w-0 py-0!" aria-labelledby="workflow-title">
  <header class="section-header">
    <p class="section-label mb-2 text-xs font-medium text-zinc-500">Working Draft · Version 0.1</p>
    <h1 id="workflow-title" class="section-title text-3xl font-medium text-zinc-800">Assessment Workflow</h1>
    <p class="section-description mt-2 text-sm leading-relaxed text-zinc-500">
      Shared reference for product owners, developers and doctors. Proposed rules remain open until agreed.
    </p>
  </header>
  <nav aria-label="Workflow sections" class="reference-navigation mt-8">
    <ul class="reference-links grid min-w-0 gap-x-8 gap-y-4 sm:grid-cols-2">
      <?php foreach ($workflow_sections as $workflow_section): ?>
        <li class="reference-item min-w-0">
          <a href="#<?= e($workflow_section['id']); ?>"
            class="reference-link inline-block text-sm text-zinc-600 underline underline-offset-4 wrap-anywhere
              hover:text-zinc-800 focus-visible:outline-2 focus-visible:outline-blue-800"><?= e($workflow_section['title']); ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <div class="section-content grid min-w-0 grid-cols-1 gap-8 mt-8">
    <?php foreach ($workflow_cards as $index => $workflow_card): ?>
      <section id="<?= e($workflow_sections[$index]['id']); ?>"
        aria-label="<?= e($workflow_sections[$index]['title']); ?>" class="section-reference min-w-0 scroll-mt-5">
        <?php component('card', $workflow_card); ?>
      </section>
    <?php endforeach; ?>
  </div>
</section>
