<?php

$page_title                   = t('dashboard.nav.system.workflow_list_2');
$page_current                 = 'workflow-list-2';
$assessment_queue_path        = 'dashboard/workflow-list-2/';
$assessment_queue_description = 'Claim new patient assessments and follow up on cases in review.';
$assessment_datatable         = true;
$assessment_expand_rows       = true;

require __DIR__ . '/assessments.php';
