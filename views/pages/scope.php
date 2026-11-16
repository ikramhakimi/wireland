<?php

$page_title       = 'Project Scope';
$page_description = '';
$page_current     = 'home';

?>
<section class="pt-50">
  <div class="container">
    <div>
      <div class="bg-zinc-400 rounded-md size-20 mb-10"></div>
      <h1 class="font-display text-4xl leading-12 text-pretty text-zinc-800" style="font-weight: 700 !important;">
        Project Scope
      </h1>

      <div class="mt-6 pt-6 border-t border-zinc-200">
        <h2 class="text-2xl font-semibold text-zinc-800">Scope of Work</h2>
        <div class="mt-8 overflow-x-auto">
          <table class="w-full border-collapse text-left text-sm leading-6 text-zinc-600">
            <caption class="pb-4 text-left text-lg font-semibold text-zinc-800">
              A. Storefront &amp; Patient Assessment
            </caption>
            <thead class="bg-zinc-100 text-zinc-800">
              <tr>
                <th scope="col" class="w-1/4 min-w-48 border border-zinc-200 px-4 py-3 font-semibold">Page</th>
                <th scope="col" class="border border-zinc-200 px-4 py-3 font-semibold">Description</th>
                <th scope="col" class="border border-zinc-200 px-4 py-3 font-semibold">Pages</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row" class="border border-zinc-200 px-4 py-4 align-top font-medium text-zinc-800">
                  Homepage
                </th>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  Product-focused introduction to RR online care with assessment and purchase calls to action.
                </td>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  <span class="block whitespace-nowrap">/home</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="border border-zinc-200 px-4 py-4 align-top font-medium text-zinc-800">
                  Treatments
                </th>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  Listing page and reusable treatment detail template covering benefits, process, FAQs and enquiries.
                </td>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  <span class="block whitespace-nowrap">/treatments</span>
                  <span class="block whitespace-nowrap">/treatment-single</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="border border-zinc-200 px-4 py-4 align-top font-medium text-zinc-800">
                  Hair Loss Issues
                </th>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  Educational listing and reusable detail template linking concerns to relevant care options.
                </td>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  <span class="block whitespace-nowrap">/hair-loss-issues</span>
                  <span class="block whitespace-nowrap">/hair-loss-issue-single</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="border border-zinc-200 px-4 py-4 align-top font-medium text-zinc-800">
                  Products
                </th>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  Catalogue and reusable product detail template with information, usage, pricing and purchase
                  eligibility.
                </td>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  <span class="block whitespace-nowrap">/products</span>
                  <span class="block whitespace-nowrap">/product-single</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="border border-zinc-200 px-4 py-4 align-top font-medium text-zinc-800">
                  Case Studies &amp; Testimonials
                </th>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  Listing of patient experiences and before-and-after results in a consistent layout.
                </td>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  <span class="block whitespace-nowrap">/case-studies</span>
                  <span class="block whitespace-nowrap">/testimonials</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="border border-zinc-200 px-4 py-4 align-top font-medium text-zinc-800">
                  Assessment
                </th>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  One predefined quiz shared across entry points, with health questions, photos, consent, submission
                  status and additional information requests. Flow: assessment → registration → doctor review →
                  prescription where appropriate → purchase.
                </td>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  <span class="block whitespace-nowrap">/assessment</span>
                  <span class="block whitespace-nowrap">/assessment/status</span>
                  <span class="block whitespace-nowrap">/assessment/additional-information</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="border border-zinc-200 px-4 py-4 align-top font-medium text-zinc-800">
                  Patient Account
                </th>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  Registration, login, password reset, profile, delivery address, order history, assessment status,
                  prescription records and basic staff-entered clinic visit logs.
                </td>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  <span class="block whitespace-nowrap">/register</span>
                  <span class="block whitespace-nowrap">/login</span>
                  <span class="block whitespace-nowrap">/forgot-password</span>
                  <span class="block whitespace-nowrap">/reset-password</span>
                  <span class="block whitespace-nowrap">/account/profile</span>
                  <span class="block whitespace-nowrap">/account/addresses</span>
                  <span class="block whitespace-nowrap">/account/orders</span>
                  <span class="block whitespace-nowrap">/account/order-single</span>
                  <span class="block whitespace-nowrap">/account/assessments</span>
                  <span class="block whitespace-nowrap">/account/prescriptions</span>
                  <span class="block whitespace-nowrap">/account/clinic-visits</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="border border-zinc-200 px-4 py-4 align-top font-medium text-zinc-800">
                  Cart &amp; Checkout
                </th>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  Cart, delivery details, basic shipping, one payment gateway, confirmation and server-side
                  prescription eligibility checks.
                </td>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  <span class="block whitespace-nowrap">/cart</span>
                  <span class="block whitespace-nowrap">/checkout</span>
                  <span class="block whitespace-nowrap">/order-confirmation</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="border border-zinc-200 px-4 py-4 align-top font-medium text-zinc-800">
                  Policy Pages
                </th>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  Privacy, terms, shipping and refund pages using RR-supplied content.
                </td>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  <span class="block whitespace-nowrap">/privacy</span>
                  <span class="block whitespace-nowrap">/terms</span>
                  <span class="block whitespace-nowrap">/shipping</span>
                  <span class="block whitespace-nowrap">/refund</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="mt-8 overflow-x-auto">
          <table class="w-full border-collapse text-left text-sm leading-6 text-zinc-600">
            <caption class="pb-4 text-left text-lg font-semibold text-zinc-800">
              B. Doctor &amp; Admin Dashboard
            </caption>
            <thead class="bg-zinc-100 text-zinc-800">
              <tr>
                <th scope="col" class="w-1/4 min-w-48 border border-zinc-200 px-4 py-3 font-semibold">Page</th>
                <th scope="col" class="border border-zinc-200 px-4 py-3 font-semibold">Description</th>
                <th scope="col" class="border border-zinc-200 px-4 py-3 font-semibold">Pages</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row" class="border border-zinc-200 px-4 py-4 align-top font-medium text-zinc-800">
                  Doctor Summary
                </th>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  Counts of pending assessments, cases requiring information and completed reviews.
                </td>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  <span class="block whitespace-nowrap">/dashboard/summary</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="border border-zinc-200 px-4 py-4 align-top font-medium text-zinc-800">
                  Assessment Review
                </th>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  Review patient responses and photos, enter notes, request information and update review status:
                  pending, more information required, approved or declined.
                </td>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  <span class="block whitespace-nowrap">/dashboard/assessments</span>
                  <span class="block whitespace-nowrap">/dashboard/assessment-single</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="border border-zinc-200 px-4 py-4 align-top font-medium text-zinc-800">
                  Prescription Management
                </th>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  Create/view patient-linked prescriptions with products, instructions, doctor identity and validity;
                  apply agreed quantity and repeat-purchase rules.
                </td>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  <span class="block whitespace-nowrap">/dashboard/prescriptions</span>
                  <span class="block whitespace-nowrap">/dashboard/prescription-create</span>
                  <span class="block whitespace-nowrap">/dashboard/prescription-single</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="border border-zinc-200 px-4 py-4 align-top font-medium text-zinc-800">
                  Products &amp; Orders
                </th>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  Manage product details, images, prices, basic stock and prescription requirements; view
                  orders/payment status and update fulfilment/tracking.
                </td>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  <span class="block whitespace-nowrap">/dashboard/products</span>
                  <span class="block whitespace-nowrap">/dashboard/product-create</span>
                  <span class="block whitespace-nowrap">/dashboard/product-edit</span>
                  <span class="block whitespace-nowrap">/dashboard/orders</span>
                  <span class="block whitespace-nowrap">/dashboard/order-single</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="border border-zinc-200 px-4 py-4 align-top font-medium text-zinc-800">
                  Patients &amp; Access
                </th>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  Manage patient submissions, basic visit logs, user/staff accounts and role permissions within one
                  shared dashboard.
                </td>
                <td class="border border-zinc-200 px-4 py-4 align-top">
                  <span class="block whitespace-nowrap">/dashboard/patients</span>
                  <span class="block whitespace-nowrap">/dashboard/patient-single</span>
                  <span class="block whitespace-nowrap">/dashboard/visit-logs</span>
                  <span class="block whitespace-nowrap">/dashboard/users</span>
                  <span class="block whitespace-nowrap">/dashboard/roles</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- <section class="mt-12" aria-labelledby="expertise-title">
        <h2 id="expertise-title" class="text-2xl font-semibold text-zinc-800">Expertise</h2>

        <div class="mt-6 grid gap-8 sm:grid-cols-2">
          <div>
            <h3 class="text-lg font-semibold text-zinc-800">Product Design</h3>
            <p class="mt-2 text-sm text-pretty text-zinc-600">
              Bringing ideas into focus. From wireframes to interactive prototypes, shaping how a product feels and flows.
            </p>
            <p class="mt-3 text-sm text-zinc-600">Wireframing · Prototyping</p>
          </div>

          <div>
            <h3 class="text-lg font-semibold text-zinc-800">Design Systems</h3>
            <p class="mt-2 text-pretty text-zinc-600">
              Creating a shared design language. Thoughtful, reusable components that keep every experience consistent.
            </p>
            <p class="mt-3 text-sm text-zinc-600">Design Systems · Figma · Sketch</p>
          </div>

          <div>
            <h3 class="text-lg font-semibold text-zinc-800">Frontend Development</h3>
            <p class="mt-2 text-pretty text-zinc-600">
              Bringing design to the browser. Building responsive interfaces with care for structure, style, and interaction.
            </p>
            <p class="mt-3 text-sm text-zinc-600">HTML · CSS · JavaScript</p>
          </div>

          <div>
            <h3 class="text-lg font-semibold text-zinc-800">Version Control</h3>
            <p class="mt-2 text-pretty text-zinc-600">
              Keeping progress clear. Tracking changes and collaborating through each iteration.
            </p>
            <p class="mt-3 text-sm text-zinc-600">Git</p>
          </div>
        </div>
      </section> -->
    </div>
    
  </div>
</section>
