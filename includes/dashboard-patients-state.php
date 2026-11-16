<?php

// Demo registrations share the directory and detail views for the current browser session.
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$patients = array_merge(
  array_values($_SESSION['dashboard_patients'] ?? []),
  require __DIR__ . '/dashboard-patients-data.php',
);
$today    = (new DateTimeImmutable('now', new DateTimeZone('Asia/Kuala_Lumpur')))->format('Y-m-d');
$query    = is_string($_GET['q'] ?? null) ? trim(substr($_GET['q'], 0, 150)) : '';
$assessment = is_string($_GET['assessment'] ?? null) ? $_GET['assessment'] : '';
$follow_up  = is_string($_GET['follow_up'] ?? null) ? $_GET['follow_up'] : '';
$group_by   = ($_GET['group_by'] ?? 'follow_up') === 'none' ? 'none' : 'follow_up';
$per_page   = in_array($_GET['per_page'] ?? '', ['5', '10', '15', '25'], true) ? (int) $_GET['per_page'] : 15;

if (!in_array($assessment, ['Pending Review', 'Reviewed', 'Not Submitted'], true)) {
  $assessment = '';
}
if (!in_array($follow_up, ['Due', 'Overdue', 'Upcoming', 'Not Scheduled'], true)) {
  $follow_up = '';
}

foreach ($patients as &$patient) {
  $date = $patient['next_follow_up'];
  $patient['follow_up_status'] = $date === null ? 'Not Scheduled'
    : ($date < $today ? 'Overdue' : ($date === $today ? 'Due' : 'Upcoming'));
}
unset($patient);

$matched = array_values(array_filter($patients, static function (array $patient) use (
  $query,
  $assessment,
  $follow_up
): bool {
  $searchable = implode(' ', [$patient['id'], $patient['name'], $patient['email'], $patient['phone']]);
  return ($query === '' || stripos($searchable, $query) !== false)
    && ($assessment === '' || $patient['assessment'] === $assessment)
    && ($follow_up === '' || $patient['follow_up_status'] === $follow_up);
}));

$total       = count($matched);
$page_count  = max(1, (int) ceil($total / $per_page));
$page_number = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT);
$page_number = min($page_count, max(1, $page_number ?: 1));
$page_url    = static function (int $page) use ($query, $assessment, $follow_up, $per_page, $group_by): string {
  return asset_url('dashboard/patients/') . '?' . http_build_query([
    'q'          => $query,
    'assessment' => $assessment,
    'follow_up'  => $follow_up,
    'per_page'   => $per_page,
    'page'       => $page,
    'group_by'   => $group_by,
  ]);
};

$rows = array_slice($matched, ($page_number - 1) * $per_page, $per_page);
$row_groups = ['Overdue' => [], 'Due' => [], 'Upcoming' => [], 'Not Scheduled' => []];
foreach ($rows as $row_order => $patient) {
  $row_groups[$patient['follow_up_status']][$row_order] = $patient;
}

return [
  'group_by'    => $group_by,
  'row_groups'  => $row_groups,
  'patients'    => $patients,
  'rows'        => $rows,
  'query'       => $query,
  'assessment'  => $assessment,
  'follow_up'   => $follow_up,
  'per_page'    => $per_page,
  'total'       => $total,
  'page_number' => $page_number,
  'page_count'  => $page_count,
  'first'       => $total === 0 ? 0 : ($page_number - 1) * $per_page + 1,
  'last'        => min($page_number * $per_page, $total),
  'page_url'    => $page_url,
];
