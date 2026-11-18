<?php

/**
 * Data: Mockup preview states (prototype)
 * Purpose: One registry for every page state reviewers can switch with ?state=.
 * Structure: group key => routes (path prefixes the group applies to), title (switcher heading),
 *            default (state used without ?state=), states (key => label, text).
 * Used by: preview_state() / preview_query() in includes/functions.php, the preview-switcher component, and
 *          scripts/export-static.php, which renders every non-default state to dist/__preview/state-<key>/ so
 *          the ?state= rewrite in vercel.json works on the static site.
 * Adding a group: add it here, read it with preview_state('<group>'), render
 *                 component('preview-switcher', ['group' => '<group>']). No other wiring is needed.
 */

return [
  'patient' => [
    'routes'  => ['/account'],
    'title'   => 'Patient state',
    'default' => 'pending',
    'states'  => [
      'new'            => ['label' => 'New patient', 'text' => 'No assessment yet'],
      'pending'        => ['label' => 'Pending', 'text' => 'Doctor is reviewing'],
      'needs_info'     => ['label' => 'Needs info', 'text' => 'Doctor asked a question'],
      'plan_ready'     => ['label' => 'Plan ready', 'text' => 'Prescription ready to order'],
      'on_treatment'   => ['label' => 'On treatment', 'text' => 'Plan ordered, using it now'],
      'checkin_due'    => ['label' => 'Check-in due', 'text' => 'Week 4 check-in with the doctor'],
      'checkin_review' => ['label' => 'Check-in sent', 'text' => 'Doctor is reviewing the check-in'],
    ],
  ],
  // 'live' keeps the real session behaviour; the others swap in sample data on GET only.
  'cart'     => [
    'routes'  => ['/cart'],
    'title'   => 'Cart state',
    'default' => 'live',
    'states'  => [
      'live'   => ['label' => 'Live', 'text' => 'Your real session cart'],
      'filled' => ['label' => 'With items', 'text' => 'Sample products'],
      'empty'  => ['label' => 'Empty', 'text' => 'No products yet'],
    ],
  ],
  'checkout' => [
    'routes'  => ['/checkout'],
    'title'   => 'Checkout state',
    'default' => 'live',
    'states'  => [
      'live'     => ['label' => 'Live', 'text' => 'Your real session checkout'],
      'form'     => ['label' => 'Checkout form', 'text' => 'Sample products'],
      'complete' => ['label' => 'Order complete', 'text' => 'Sample confirmation'],
      'empty'    => ['label' => 'Empty cart', 'text' => 'Nothing to check out'],
    ],
  ],
];
