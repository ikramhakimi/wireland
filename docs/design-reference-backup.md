# Design Reference (`/design`)

The `/design` page is the source of truth for foundations and components. Each documented component has one
demo file that shows its supported sizes, variants, and states, plus guidance on when to use it.

## Map

| What | Where |
|---|---|
| Section order, sidebar groups, file names | `includes/design-sections.php` |
| One section's data and demo markup | `views/components/design/sections/<file>.php` |
| Section header (title, guidance, sources) | `views/components/design/section-header.php` |
| Sidebar (reads the registry) | `views/components/design/sidebar.php` |
| Page (loops the registry) | `views/pages/design.php` |

Section files are named after the component they document: `components/badge.php` →
`design/sections/badge.php`. Foundations use their topic name (`colors`, `font-size`, `spacing`).

## Using the reference for new UI

1. Read the registry to see which components exist.
2. Open the section files for the components you need. The header description says when to use the
   component (and when to use another one instead); the demos show the documented sizes and variants.
3. Build with `component(...)` using only documented options. Do not invent a variant or override its
   typography, padding, radius, or colors.
4. If a pattern is missing, propose the smallest extension before implementing it (see AGENTS.md).

Items with `'target' => null` in the registry are not documented yet: Shadows, Motion, Sidebar, Header,
Toasts, Forms & Validation, Data Tables, Dashboard Summary. Ask before inventing a pattern for these.

## Updating a section

When a component's API, variants, or behavior change, update its section file in the same change.
Keep demo data in the PHP block at the top of that file; `component()` isolates scope, so a section cannot
read variables from `design.php` or from another section.

## Adding a section

1. Add an entry to the right group in `includes/design-sections.php`:
   `['label' => 'Badges', 'target' => 'design-badges', 'file' => 'badge']`.
   The entry's position sets both the sidebar order and the page order.
2. Create `views/components/design/sections/<file>.php` following this pattern:

```php
<?php

$badge_examples = [
  // demo data
];

?>
<section id="design-badges" aria-labelledby="design-badges-title" class="section border-t border-zinc-200">
  <?php component('components/design/section-header', [
    'id'          => 'design-badges',
    'title'       => 'Badges',
    'description' => 'Use badges for short category or status labels.',
    'sources'     => ['views/components/badge.php'],
  ]); ?>
  <div class="section-content grid gap-10 mt-6 text-sm leading-relaxed">
    <div class="section-demo p-10 text-base rounded-md border border-zinc-200 bg-zinc-100">
      <h3 class="section-demo-title -ml-5 -mt-5 mb-10 text-title-sm font-semibold color-strong">Outline</h3>
      <!-- demo -->
    </div>
  </div>
</section>
```

- The section `id` must match the registry `target`; the header `id` builds `<id>-title` for `aria-labelledby`.
- `section-header` data: `id`, `title`, `description` (plain text), `sources` (paths, shown as code),
  optional `source_note` (plain text before the sources, such as "Tailwind utilities").
- Keep `.section`, `.section-content`, and `.section-demo` as static markup, with the classes shown above.

## Known inconsistencies

Some sections still use their original header markup instead of `section-header`, because their
classes differ (`color-muted` sources, `·` separators, or `<code>` in the description): input-group,
input-group-text, stepper, file-upload, toggle-collapse, dashboard-header, modal, drawer, dropdown,
tooltip, marquee. Use `section-header` for new sections; do not copy these headers.
