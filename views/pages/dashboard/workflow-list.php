<?php

$page_title                   = t('dashboard.nav.system.workflow_list');
$page_current                 = 'workflow-list';
$assessment_queue_path        = 'dashboard/workflow-list/';
$assessment_queue_description = 'Claim new patient assessments and follow up on cases in review.';
$assessment_datatable         = true;

require __DIR__ . '/assessments.php';
