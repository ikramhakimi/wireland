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
  // Full version at /account/full and the other account pages.
  'patient' => [
    'routes'  => ['/account'],
    'title'   => 'Patient state',
    'default' => 'pending',
    'states'  => [
      'new'            => ['label' => 'New patient', 'text' => 'No assessment yet'],
      'pending'        => ['label' => 'Pending', 'text' => 'Doctor is reviewing'],
      'needs_info'     => ['label' => 'Needs info', 'text' => 'Doctor asked a question'],
      'plan_ready'     => ['label' => 'Plan ready', 'text' => 'Prescription ready to order'],
      'ordered'        => ['label' => 'Ordered', 'text' => 'Plan ordered, on its way'],
      'received'       => ['label' => 'Received', 'text' => 'Plan delivered, picking a start date'],
      'on_treatment'   => ['label' => 'On treatment', 'text' => 'Plan ordered, using it now'],
      'checkin_due'    => ['label' => 'Check-in due', 'text' => 'Week 4 check-in with the doctor'],
      'checkin_review' => ['label' => 'Check-in sent', 'text' => 'Doctor is reviewing the check-in'],
      'plan_updated'   => ['label' => 'Check-in reviewed', 'text' => 'Doctor replied, refill and next check-in'],
    ],
  ],
  // /account (simplified overview). Assessment states reuse the 'patient' data; the rest are product follow-ups.
  // 'live' reads the session shared with /dashboard/follow-ups. Same keys as 'patient' keep the same meaning.
  'overview' => [
    'routes'  => ['/account'],
    'title'   => 'Patient journey',
    'default' => 'live',
    'states'  => [
      'live'       => ['label' => 'Live', 'text' => 'Follows what staff record in the dashboard'],
      'new'        => ['label' => 'New patient', 'text' => 'No assessment yet'],
      'pending'    => ['label' => 'Pending', 'text' => 'Doctor is reviewing'],
      'needs_info' => ['label' => 'Needs info', 'text' => 'Doctor asked a question'],
      'plan_ready' => ['label' => 'Plan ready', 'text' => 'Prescription ready to order'],
      'packed'     => ['label' => 'Packing', 'text' => 'Order placed, not shipped yet'],
      'shipped'    => ['label' => 'On the way', 'text' => 'Shipped, tracking shown'],
      'upcoming'   => ['label' => 'Follow-up soon', 'text' => 'Delivered, follow-up date ahead'],
      'contacting' => ['label' => 'Follow-up today', 'text' => 'Due, check-in open'],
      'retrying'   => ['label' => 'Waiting for reply', 'text' => 'No reply, attempt 2 of 3'],
      'doctor'     => ['label' => 'With doctor', 'text' => 'Handed over, doctor summary shown'],
      'done'       => ['label' => 'Done, prescription', 'text' => 'Refill needs a check-in'],
      'done_care'  => ['label' => 'Done, care product', 'text' => 'Order the refill directly'],
      'closed'     => ['label' => 'Closed', 'text' => 'No reply after 3 attempts'],
      'stopped'    => ['label' => 'Stopped', 'text' => 'Patient stopped, card archived'],
      'care_shipped'    => ['label' => 'No assessment: on the way', 'text' => 'Bought a care product'],
      'care_upcoming'   => ['label' => 'No assessment: follow-up soon', 'text' => 'Assessment offer on top'],
      'care_contacting' => ['label' => 'No assessment: follow-up today', 'text' => 'Check-in open'],
      'care_doctor'     => ['label' => 'No assessment: with doctor', 'text' => 'Offer on the card'],
      'care_done'       => ['label' => 'No assessment: done', 'text' => 'Little progress, offer on the card'],
      'care_shipped_pending'    => ['label' => 'Order on the way + assessment sent', 'text' => 'Doctor reviewing'],
      'care_shipped_needs_info' => ['label' => 'Order on the way + doctor asks', 'text' => 'Reply needed'],
      'care_done_plan_ready'    => ['label' => 'Care order done + plan ready', 'text' => 'Order the plan'],
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
      'live'  => ['label' => 'Live', 'text' => 'Your real session checkout'],
      'form'  => ['label' => 'Checkout form', 'text' => 'Sample products'],
      'empty' => ['label' => 'Empty cart', 'text' => 'Nothing to check out'],
    ],
  ],
];
