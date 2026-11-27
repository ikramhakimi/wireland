<?php

/**
 * Prepare assessment display data for the queue rows and Workflow Board cards.
 * Returns a formatter for records in the supplied assessment state.
 */
$config    = $assessments['config'];
$questions = $assessments['questions'];
$today     = $assessments['today'];

require __DIR__ . '/checkin-data.php';

return static function (array $record) use (
  $assessments,
  $config,
  $questions,
  $today,
  $checkin_questions
): array {
  $status  = $config['statuses'][$record['status']];
  $is_done = in_array($record['status'], ['reviewed', 'not_suitable'], true);
  $changes = assessment_answer_labels($questions['changes'], $record['answers']['changes'] ?? []);
  $flags   = assessment_answer_labels(
    $questions['health'],
    array_diff((array) ($record['answers']['health'] ?? []), ['none']),
  );
  $rounds  = count($record['thread']);
  // Renewal: the patient's check-in answer for one question, as its label.
  $is_renewal    = $record['type'] === 'renewal';
  $checkin_label = static function (string $question_id) use ($record, $checkin_questions): string {
    $question = array_column($checkin_questions, null, 'id')[$question_id];

    return implode(', ', assessment_answer_labels($question, $record['checkin'][$question_id] ?? []));
  };
  $doctor  = $assessments['doctors'][$record['doctor'] ?? '']['name'] ?? '';
  $waiting = assessment_days_between($record['submitted'], $today);

  if ($is_done) {
    $decision   = $record['status'] === 'reviewed' ? assessment_plan_label($record, $config) : '';
    $date_label = 'Decided';
    $date_value = assessment_label_date($record['decided_on']);
    $date_hint  = trim(($decision !== '' ? $decision . ' · ' : '') . $doctor);
  } elseif ($record['status'] === 'awaiting') {
    $date_label = 'Asked';
    $date_value = assessment_label_date($record['asked_on']);
    $date_hint  = assessment_days_ago(assessment_days_between($record['asked_on'], $today))
      . ($rounds > 1 ? ' · Question ' . $rounds : '');
  } else {
    $date_label = 'Submitted';
    $date_value = assessment_label_date($record['submitted']);
    $date_hint  = $waiting > 0 ? 'Waiting ' . $waiting . ($waiting === 1 ? ' day' : ' days') : 'Today';
  }

  return [
    'record'      => $record,
    'patient'     => $assessments['patients'][$record['patient_id']] ?? ['name' => $record['patient_id']],
    'status'      => $status,
    'changes'     => $is_renewal
      ? 'Renewing '
        . ($assessments['records'][$record['renewal_of']]['prescription']['id'] ?? $record['renewal_of'])
      : implode(', ', $changes),
    'duration'    => $is_renewal
      ? 'Since last plan: ' . lcfirst($checkin_label('change'))
      : 'Noticed '
        . lcfirst(assessment_answer_labels($questions['duration'], $record['answers']['duration'] ?? '')[0] ?? ''),
    // Renewal badge, and the prescription being renewed in place of the reported changes.
    'renewal'     => $is_renewal ? $config['renewal']['label'] : '',
    'flags'       => array_values($flags),
    'date_label'  => $date_label,
    'date_value'  => $date_value,
    'date_hint'   => $date_hint,
    'action'      => $record['status'] === 'new' ? 'claim'
      : ($is_done && !assessment_consultation_pending($record) ? 'view' : 'review'),
    // Reviewed plan waiting for its consultation outcome, e.g. "Video Call Pending".
    'consult'     => assessment_consultation_pending($record)
      ? $config['consultation']['modes'][$record['consultation']['mode']] . ' Pending' : '',
    'review_href' => ($assessments['review_url'])($record['id']),
  ];
};
