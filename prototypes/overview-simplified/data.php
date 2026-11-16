<?php

// Presentation-only selections; all reporting values come from the dashboard snapshot.
$metric_sets = [
  'pulse' => [
    ['label' => 'Sales', 'value' => $overview['summary_cards'][0]['value'], 'note' => '18% higher than the previous 7 days', 'comparison' => '+18%', 'comparison_label' => '18% higher', 'report' => 'business'],
    ['label' => 'Orders', 'value' => $overview['summary_cards'][2]['value'], 'note' => '12% fewer than the previous 7 days', 'comparison' => '-12%', 'comparison_label' => '12% fewer', 'report' => 'business'],
    ['label' => 'Assessments', 'value' => $overview['summary_cards'][1]['value'], 'note' => 'Completed during this period', 'report' => 'patients'],
  ],
  'business' => [
    ['label' => 'Sales', 'value' => $overview['summary_cards'][0]['value'], 'note' => '18% higher than the previous 7 days', 'comparison' => '+18%', 'comparison_label' => '18% higher', 'report' => 'business'],
    ['label' => 'Orders', 'value' => $overview['summary_cards'][2]['value'], 'note' => '12% fewer than the previous 7 days', 'comparison' => '-12%', 'comparison_label' => '12% fewer', 'report' => 'business'],
    ['label' => 'Units sold', 'value' => '60', 'note' => 'Across successful orders', 'report' => 'products'],
  ],
  'patients' => [
    ['label' => 'Assessments completed', 'value' => '128', 'note' => '18% more than the previous 7 days', 'comparison' => '+18%', 'comparison_label' => '18% more', 'report' => 'patients'],
    ['label' => 'Completion rate', 'value' => '80%', 'note' => '128 of 160 started assessments', 'report' => 'patients'],
    ['label' => 'Purchase conversion', 'value' => '50%', 'note' => '42 of 84 eligible patients purchased', 'report' => 'patients'],
  ],
  'website' => [
    ['label' => 'Visitors', 'value' => '2,840', 'note' => '9% fewer than the previous 7 days', 'comparison' => '-9%', 'comparison_label' => '9% fewer', 'report' => 'website'],
    ['label' => 'Sessions', 'value' => '3,260', 'note' => '11% more than the previous 7 days', 'comparison' => '+11%', 'comparison_label' => '11% more', 'report' => 'website'],
    ['label' => 'Page views', 'value' => '8,920', 'note' => '14% more than the previous 7 days', 'comparison' => '+14%', 'comparison_label' => '14% more', 'report' => 'website'],
  ],
];
$report_titles = [
  'business'   => 'Sales & orders',
  'products'   => 'Product sales',
  'patients'   => 'Patient journey',
  'website'    => 'Website performance',
];
$report_links = [
  ['report' => 'products', 'label' => 'Product sales', 'detail' => 'Units and revenue by product'],
  ['report' => 'patients', 'label' => 'Patient journey', 'detail' => 'Assessments, reviews and purchases'],
  ['report' => 'website', 'label' => 'Website performance', 'detail' => 'Visitors, traffic and page views'],
];
$domains = [
  'business' => 'Business',
  'patients' => 'Patients',
  'website'  => 'Website',
];
