<?php
/**
 * Section: Treatment lab intro (template)
 * Purpose: Treatment name, short promise and a wide image slot.
 * Data: topic, title, subtitle.
 */
?>
<section class="treatment-lab-intro">
  <div class="container">
    <div class="border-b border-zinc-200  pb-10 pt-30">
      <?php component('headline', [
        'topic'         => $topic ?? '',
        'title'         => $title ?? '',
        'subtitle'      => $subtitle ?? '',
        'title_size'    => 'large',
        'is_page_title' => true,
      ]); ?>
    </div>
  </div>
</section>
