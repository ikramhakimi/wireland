<?php

/**
 * Page: Account profile
 * Purpose: Lets patients keep their details, delivery address, contact preferences and password up to date,
 *          and download or delete their data (PDPA).
 * Structure: Account layout; header; two columns from xl (checkout style): forms under filled heading bars
 *            (personal details, delivery address, notifications, password), and a zinc-100 aside with an
 *            account summary, your data (download, delete with a confirmation modal) and log out.
 * Data: includes/account-data.php (patient). UI only: the forms do not save.
 */

$page_title       = 'Profile | RR HairClinic';
$page_description = 'Manage your RR HairClinic account details.';
$page_current     = 'account-profile';

$account = require __DIR__ . '/../../../includes/account-data.php';
$patient = $account['patient'];

$malaysia_states = [
  'johor'           => 'Johor',
  'kedah'           => 'Kedah',
  'kelantan'        => 'Kelantan',
  'kuala-lumpur'    => 'W.P. Kuala Lumpur',
  'labuan'          => 'W.P. Labuan',
  'melaka'          => 'Melaka',
  'negeri-sembilan' => 'Negeri Sembilan',
  'pahang'          => 'Pahang',
  'penang'          => 'Pulau Pinang',
  'perak'           => 'Perak',
  'perlis'          => 'Perlis',
  'putrajaya'       => 'W.P. Putrajaya',
  'sabah'           => 'Sabah',
  'sarawak'         => 'Sarawak',
  'selangor'        => 'Selangor',
  'terengganu'      => 'Terengganu',
];

$details_fields = [
  [
    'id'           => 'profile-name',
    'label'        => 'Full Name',
    'name'         => 'full_name',
    'value'        => $patient['full_name'],
    'autocomplete' => 'name',
    'required'     => true,
    'wide'         => true,
  ],
  [
    'id'           => 'profile-email',
    'label'        => 'Email',
    'type'         => 'email',
    'name'         => 'email',
    'value'        => $patient['email'],
    'autocomplete' => 'email',
    'required'     => true,
  ],
  [
    'id'           => 'profile-phone',
    'label'        => 'Phone Number',
    'name'         => 'phone',
    'value'        => $patient['phone'],
    'autocomplete' => 'tel',
    'helper'       => 'We send doctor replies here on WhatsApp.',
    'required'     => true,
  ],
  [
    'id'           => 'profile-dob',
    'label'        => 'Date of Birth',
    'name'         => 'date_of_birth',
    'value'        => $patient['date_of_birth'],
    'placeholder'  => 'DD/MM/YYYY',
    'autocomplete' => 'bday',
    'helper'       => 'Our doctor needs this to recommend safe treatment.',
    'required'     => true,
  ],
];
$address_fields = [
  [
    'id'           => 'profile-street',
    'label'        => 'Street Address',
    'name'         => 'street',
    'value'        => $patient['address']['street'],
    'autocomplete' => 'street-address',
    'required'     => true,
    'wide'         => true,
  ],
  [
    'id'           => 'profile-city',
    'label'        => 'City',
    'name'         => 'city',
    'value'        => $patient['address']['city'],
    'autocomplete' => 'address-level2',
    'required'     => true,
  ],
  [
    'id'           => 'profile-postcode',
    'label'        => 'Postcode',
    'name'         => 'postcode',
    'value'        => $patient['address']['postcode'],
    'autocomplete' => 'postal-code',
    'maxlength'    => 5,
    'required'     => true,
  ],
  [
    'id'       => 'profile-state',
    'label'    => 'State',
    'type'     => 'select',
    'name'     => 'state',
    'value'    => $patient['address']['state'],
    'required' => true,
    'options'  => array_map(
      static fn (string $value, string $label): array => ['value' => $value, 'label' => $label],
      array_keys($malaysia_states),
      $malaysia_states,
    ),
  ],
];
$notification_options = [
  [
    'key'   => 'doctor_whatsapp',
    'label' => 'Doctor replies on WhatsApp',
    'text'  => 'Questions from your doctor and when your plan is ready.',
  ],
  [
    'key'   => 'doctor_email',
    'label' => 'Doctor replies by email',
    'text'  => 'A copy of every doctor update, for your records.',
  ],
  [
    'key'   => 'reminders',
    'label' => 'Check-ins and refill reminders',
    'text'  => 'How your treatment is going, and when you’re running low.',
  ],
  [
    'key'   => 'offers',
    'label' => 'Offers and hair care tips',
    'text'  => 'Occasional emails. Unsubscribe any time.',
  ],
];
$password_fields = [
  [
    'id'           => 'profile-password-current',
    'label'        => 'Current Password',
    'type'         => 'password',
    'name'         => 'current_password',
    'autocomplete' => 'current-password',
    'required'     => true,
    'wide'         => true,
  ],
  [
    'id'           => 'profile-password-new',
    'label'        => 'New Password',
    'type'         => 'password',
    'name'         => 'new_password',
    'autocomplete' => 'new-password',
    'minlength'    => 8,
    'helper'       => 'Use at least 8 characters.',
    'required'     => true,
    'wide'         => true,
  ],
];
$save_button = static fn (string $label, string $form): array => [
  'label'   => $label,
  'element' => 'button',
  'type'    => 'submit',
  'color'   => 'primary',
  'form'    => $form,
  'class'   => 'account-profile-save w-full sm:w-auto',
];
$download_button = [
  'label'   => 'Download My Data',
  'element' => 'button',
  'color'   => 'secondary',
  'class'   => 'account-privacy-download w-full',
];
$delete_button = [
  'label'         => 'Delete My Account',
  'element'       => 'button',
  'color'         => 'secondary',
  'aria_controls' => 'profile-delete-modal',
  'class'         => 'account-privacy-delete w-full',
  'js_hook'       => 'js-component-modal-open',
];
$delete_consequences = [
  'Your profile, saved answers and preferences are deleted.',
  'You’re logged out and can’t sign in with this email again unless you create a new account.',
  'Orders already on the way are still delivered.',
  'Medical records we must keep by law are stored securely and removed once the legal period ends.',
];
$delete_password_field = [
  'id'           => 'profile-delete-password',
  'label'        => 'Enter your password to confirm',
  'type'         => 'password',
  'name'         => 'password',
  'autocomplete' => 'current-password',
  'required'     => true,
];
$delete_modal = [
  'id'          => 'profile-delete-modal',
  'title'       => 'Delete your account?',
  'description' => 'This can’t be undone.',
  'content'     => static function () use ($delete_consequences, $delete_password_field): void {
    ?>
    <ul class="account-delete-list grid gap-2 pl-5 text-sm text-pretty list-disc" role="list">
      <?php foreach ($delete_consequences as $consequence): ?>
        <li class="account-delete-item"><?= e($consequence); ?></li>
      <?php endforeach; ?>
    </ul>
    <form id="profile-delete-form" method="post" action="#" class="account-delete-form mt-5">
      <?php component('forms/field', $delete_password_field); ?>
    </form>
    <?php
  },
  'actions'     => static function (): void {
    component('button', [
      'label'   => 'Keep My Account',
      'element' => 'button',
      'color'   => 'secondary',
      'js_hook' => 'js-component-modal-close',
    ]);
    component('button', [
      'label'   => 'Delete My Account',
      'element' => 'button',
      'type'    => 'submit',
      'color'   => 'primary',
      'form'    => 'profile-delete-form',
    ]);
  },
];
$logout_button = [
  'label' => 'Log Out',
  'href'  => asset_url('login'),
  'color' => 'secondary',
  'class' => 'account-logout w-full',
];
$aside_facts  = [
  ['label' => 'Phone', 'value' => $patient['phone']],
  [
    'label' => 'Delivers to',
    'value' => $patient['address']['city'] . ', ' . ($malaysia_states[$patient['address']['state']] ?? ''),
  ],
];
$profile_sections = [
  [
    'id'          => 'profile-details',
    'title'       => 'Personal details',
    'description' => 'Your doctor sees these when reviewing your assessment.',
    'fields'      => $details_fields,
    'button'      => $save_button('Save Details', 'profile-details-form'),
  ],
  [
    'id'          => 'profile-address',
    'title'       => 'Delivery address',
    'description' => 'Where we send your orders. Packaging is discreet and unmarked.',
    'fields'      => $address_fields,
    'button'      => $save_button('Save Address', 'profile-address-form'),
  ],
];

$account_layout = [
  'nav'           => $account['nav'],
  'current'       => 'profile',
  'preview_group' => 'patient',
  'content'       => static function () use (
    $patient,
    $aside_facts,
    $profile_sections,
    $notification_options,
    $password_fields,
    $save_button,
    $download_button,
    $delete_button,
    $delete_modal,
    $logout_button
  ): void {
    ?>
    <div class="account-profile">
      <header class="account-header">
        <h1 class="account-title text-title-md font-semibold text-pretty color-strong">Profile</h1>
        <p class="account-description mt-2 max-w-lg text-sm text-pretty color-muted">
          Keep your details up to date so your doctor and deliveries can reach you.
        </p>
      </header>

      <div class="account-layout grid items-start gap-8 mt-8 xl:grid-cols-12">
        <div class="account-main grid gap-10 min-w-0 xl:col-span-8">
          <?php foreach ($profile_sections as $section): ?>
            <section class="account-section" aria-labelledby="<?= e($section['id']); ?>-title">
              <?php component('account/section-heading', [
                'id'    => $section['id'] . '-title',
                'title' => $section['title'],
              ]); ?>
              <p class="account-section-text mt-4 text-sm text-pretty color-muted"><?= e($section['description']); ?></p>
              <form id="<?= e($section['id']); ?>-form" method="post" action="#"
                class="account-profile-form grid gap-y-4 gap-x-3 mt-5 sm:grid-cols-2">
                <?php foreach ($section['fields'] as $field): ?>
                  <div class="account-profile-field min-w-0<?= !empty($field['wide']) ? ' sm:col-span-2' : ''; ?>">
                    <?php component('forms/field', $field); ?>
                  </div>
                <?php endforeach; ?>
              </form>
              <div class="account-section-actions mt-6">
                <?php component('button', $section['button']); ?>
              </div>
            </section>
          <?php endforeach; ?>

          <section class="account-section" aria-labelledby="profile-notifications-title">
            <?php component('account/section-heading', [
              'id'    => 'profile-notifications-title',
              'title' => 'Notifications',
            ]); ?>
            <p class="account-section-text mt-4 text-sm text-pretty color-muted">
              Choose how we contact you. Order and delivery updates are always sent.
            </p>
            <form id="profile-notifications-form" method="post" action="#"
              class="account-profile-form grid mt-2 divide-y divide-dashed divide-zinc-200">
              <?php foreach ($notification_options as $option): ?>
                <div class="account-profile-option py-4">
                  <?php component('forms/choice', [
                    'id'      => 'profile-notify-' . str_replace('_', '-', $option['key']),
                    'label'   => $option['label'],
                    'type'    => 'switch',
                    'name'    => 'notifications[' . $option['key'] . ']',
                    'checked' => $patient['notifications'][$option['key']] ?? false,
                  ]); ?>
                  <p class="account-profile-option-text mt-1 text-sm text-pretty color-muted"><?= e($option['text']); ?></p>
                </div>
              <?php endforeach; ?>
            </form>
            <div class="account-section-actions mt-2">
              <?php component('button', $save_button('Save Preferences', 'profile-notifications-form')); ?>
            </div>
          </section>

          <section class="account-section" aria-labelledby="profile-password-title">
            <?php component('account/section-heading', ['id' => 'profile-password-title', 'title' => 'Password']); ?>
            <form id="profile-password-form" method="post" action="#"
              class="account-profile-form grid gap-y-4 max-w-sm mt-5">
              <?php foreach ($password_fields as $field): ?>
                <?php component('forms/field', $field); ?>
              <?php endforeach; ?>
            </form>
            <div class="account-section-actions mt-6">
              <?php component('button', $save_button('Change Password', 'profile-password-form')); ?>
            </div>
          </section>
        </div>

        <aside class="account-aside grid gap-4 p-5 rounded-lg bg-zinc-100 xl:sticky xl:top-6 xl:col-span-4"
          aria-labelledby="account-aside-title">
          <div class="account-aside-header">
            <h2 id="account-aside-title" class="account-aside-title text-base font-semibold color-strong">
              <?= e($patient['full_name']); ?>
            </h2>
            <p class="account-aside-email mt-1 text-sm color-muted wrap-anywhere"><?= e($patient['email']); ?></p>
          </div>
          <?php component('facts', [
            'items'  => $aside_facts,
            'layout' => 'rows',
            'class'  => 'account-aside-facts',
          ]); ?>

          <section class="account-privacy grid gap-3 pt-4 border-t border-zinc-200" aria-labelledby="profile-privacy-title">
            <h3 id="profile-privacy-title" class="account-privacy-title text-sm font-semibold color-strong">Your data</h3>
            <p class="account-privacy-text text-sm text-pretty color-muted">
              Your assessments and prescriptions are seen only by our clinical team and protected under Malaysia’s
              PDPA. Download a copy any time, or ask us to delete your account.
            </p>
            <div class="account-privacy-actions grid gap-2">
              <?php component('button', $download_button); ?>
              <?php component('button', $delete_button); ?>
            </div>
            <?php component('modal', $delete_modal); ?>
          </section>

          <div class="account-logout-wrap pt-4 border-t border-zinc-200">
            <?php component('button', $logout_button); ?>
          </div>
        </aside>
      </div>
    </div>
    <?php
  },
];

component('account/layout', $account_layout);
?>
<script src="<?= asset_url('assets/js/drawer.js'); ?>?v=<?= filemtime(__DIR__ . '/../../../assets/js/drawer.js'); ?>" defer></script>
