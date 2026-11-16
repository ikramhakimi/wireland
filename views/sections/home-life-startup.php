<?php
$startup_headline = [
  'topic'     => 'Getting Started',
  'title'     => 'Your hair regrowth journey starts today',
  'alignment' => 'center',
];
$treatment_headline = [
  'title'     => 'Treatment options to target all stages of hair loss',
  'subtitle'  => 'Take our free assessment to find the right treatment for your hair type',
  'alignment' => 'center',
];
?>

<section class="section bg-white rounded-2xl lg:m-2">
  <div class="container">
    <?php component('headline', $startup_headline); ?>

    <ol class="mt-10 grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-4">
      <li class="rounded-lg bg-zinc-100 p-5 sm:p-7">
        <span class="inline-flex-center size-12 rounded-full bg-zinc-300 text-lg font-semibold text-zinc-700">
          <span class="sr-only">Step </span>1
        </span>
        <h3 class="mt-10 text-lg font-semibold text-zinc-800">Take your free assessment</h3>
        <p class="mt-3 text-sm text-pretty text-zinc-500">
          Tell us about your hair concerns, medical history and what you would like to achieve.
        </p>
      </li>
      <li class="rounded-lg bg-zinc-100 p-5 sm:p-7">
        <span class="inline-flex-center size-12 rounded-full bg-zinc-300 text-lg font-semibold text-zinc-700">
          <span class="sr-only">Step </span>2
        </span>
        <h3 class="mt-10 text-lg font-semibold text-zinc-800">Find your treatment plan</h3>
        <p class="mt-3 text-sm text-pretty text-zinc-500">
          Explore suitable options with our team and choose a plan that fits your routine.
        </p>
      </li>
      <li class="rounded-lg bg-zinc-100 p-5 sm:p-7">
        <span class="inline-flex-center size-12 rounded-full bg-zinc-300 text-lg font-semibold text-zinc-700">
          <span class="sr-only">Step </span>3
        </span>
        <h3 class="mt-10 text-lg font-semibold text-zinc-800">Start your daily routine</h3>
        <p class="mt-3 text-sm text-pretty text-zinc-500">
          Begin your agreed treatment with clear guidance on how to make it part of your day.
        </p>
      </li>
      <li class="rounded-lg bg-zinc-100 p-5 sm:p-7">
        <span class="inline-flex-center size-12 rounded-full bg-zinc-300 text-lg font-semibold text-zinc-700">
          <span class="sr-only">Step </span>4
        </span>
        <h3 class="mt-10 text-lg font-semibold text-zinc-800">Keep track of your progress</h3>
        <p class="mt-3 text-sm text-pretty text-zinc-500">
          Stay consistent and check in with our team for support throughout your hair journey.
        </p>
      </li>
    </ol>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php component('headline', $treatment_headline); ?>

    <div class="mt-10 grid grid-cols-1 gap-2 md:grid-cols-3">
      <article class="overflow-hidden rounded-lg bg-white">
        <div class="m-2 flex-center aspect-5/4 rounded-md bg-zinc-200">
          <img
            src="assets/images/bald/bald-temples-crown.svg"
            alt="Illustration of thinning at the temples and crown"
            class="size-40 object-contain"
            width="160"
            height="160"
            loading="lazy"
          >
        </div>
        <div class="p-5 sm:p-7">
          <h3 class="text-xl font-semibold text-zinc-800">Thinning and receding</h3>
          <p class="mt-3 text-sm text-pretty text-zinc-500">
            Explore a personalised plan for changes in both your hairline and overall coverage.
          </p>
        </div>
      </article>
      <article class="overflow-hidden rounded-lg bg-white">
        <div class="m-2 flex-center aspect-5/4 rounded-md bg-zinc-200">
          <img
            src="assets/images/bald/bald-moderate.svg"
            alt="Illustration of thinning around the crown"
            class="size-40 object-contain"
            width="160"
            height="160"
            loading="lazy"
          >
        </div>
        <div class="p-5 sm:p-7">
          <h3 class="text-xl font-semibold text-zinc-800">Thinning of the crown</h3>
          <p class="mt-3 text-sm text-pretty text-zinc-500">
            Find care options tailored to reduced density and visible thinning at the top of your head.
          </p>
        </div>
      </article>
      <article class="overflow-hidden rounded-lg bg-white">
        <div class="m-2 flex-center aspect-5/4 rounded-md bg-zinc-200">
          <img
            src="assets/images/bald/bald-temples.svg"
            alt="Illustration of a receding hairline at the temples"
            class="size-40 object-contain"
            width="160"
            height="160"
            loading="lazy"
          >
        </div>
        <div class="p-5 sm:p-7">
          <h3 class="text-xl font-semibold text-zinc-800">Receding hairlines</h3>
          <p class="mt-3 text-sm text-pretty text-zinc-500">
            Understand your options for a changing hairline and thinning around the temples.
          </p>
        </div>
      </article>
    </div>
  </div>
</section>
