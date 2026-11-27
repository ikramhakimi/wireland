# Build mode

Use Rules and Phases 5–6 once directions are chosen, Phase 6 for standalone verification, and Phase 7
for iteration and promotion.

## Rules

1. **Never touch production.** Write only inside `prototypes/<slug>/`, plus one `@import` line in
   `prototypes/_kit/prototype.css` when the prototype has a `variant.css`. Nothing in production imports
   from `prototypes/`. Integration happens only after the user picks (Phase 7).
2. **Every variant fully works.** Real interactions, real states, realistic content. No dead buttons.
3. **The kit is chrome, not a contestant.** Use `prototypes/_kit/` as is. Do not open, restyle, or rewrite
   its files, and do not read older prototypes for the harness pattern.
4. **Check every variant.** Use the light design checks below during exploration. On `keep`, check
   the selected variant against the production design system.

## Phase 5 — Build

The shared kit in `prototypes/_kit/` provides the page shell, picker, and CSS build. A prototype holds only
design work:

```
prototypes/<slug>/
  index.php       config + one require (below)
  data.php        static data and config arrays for all variants (optional)
  <variant>.php   one file per variant, named after the direction; markup only, no <html>/<head>
  variant.css     variant-only styles (optional; only what Tailwind utilities cannot express)
  prototype.js    variant behavior (optional; loaded automatically, binds on DOMContentLoaded)
  references.md   reference notes and pattern table (reference mode only)
```

```php
<?php

/**
 * Prototype: Treatment hero
 * Source: views/pages/treatment-1.php (hero section)   ← required: `keep` replaces this piece
 * Variants: Guided, Ledger, Story-led. Pinned: none.
 */

require __DIR__ . '/../_kit/bootstrap.php';   // first: helpers + correct asset_url() base
require __DIR__ . '/data.php';

$page_title    = 'Treatment Hero | Prototype';
$variants      = ['Guided' => 'guided', 'Ledger' => 'ledger', 'Story-led' => 'story-led'];
$prototype_dir = __DIR__;

require __DIR__ . '/../_kit/harness.php';
```

The harness renders one variant per request (`?v=<n>`) inside the production navbar and footer, loads
fonts, `_kit/build.css`, production JS, and `prototype.js` if present. Optional flags before the require:
`$harness_chrome = false` (no navbar/footer), `$picker_replay = true` (only when a variant has motion to
re-run), `$picker_top = true` (only when a variant occupies bottom-center). Variant files can call
`component()` and `section()` directly.

If `prototypes/<slug>/` already exists, reuse it instead of starting over.

### CSS: split from production

Never edit `assets/css/app.css` or `assets/build/app.css` for a prototype. `_kit/prototype.css` imports the
production source and scans all of `prototypes/`, so Tailwind utilities used in any variant compile into
`_kit/build.css` with no extra setup. If the prototype has a `variant.css`, add one line under
`/* Prototype variant styles */` in `_kit/prototype.css` (imported, so the tokens it uses are emitted):

```css
@import "../<slug>/variant.css";
```

Do not run the compile yourself (AGENTS.md). One watch covers every prototype; if it is not running, give
the user this command to run from the project root:

```
npx @tailwindcss/cli -i prototypes/_kit/prototype.css -o prototypes/_kit/build.css --watch
```

**`free` variants** do not depend on the Tailwind build. Put the styles in one `<style>` block at the top of
the variant file, scoped under a root class named after the variant (`.desk`, `.desk-*`), with the palette
as custom properties on that root. No `variant.css`, no `@import`, no inline `style=""` attributes. Light
theme only unless asked; handle `prefers-reduced-motion`. Behavior goes in `prototype.js` in its own block,
bound to the variant's `js-` hooks.

### Prototype presentation

- Use labeled image placeholders at the intended aspect ratio (`aspect-square rounded-lg bg-zinc-300`
  for square slots). Flag variants that depend on a specific image in the handoff.
- Use Tailwind utilities first. Scope any `variant.css` rules to the prototype. Follow AGENTS.md for
  formatting and advance notice of CSS or JS changes.
- Render one variant at a time at full size in realistic page context. Keep picker labels to about
  10 characters so they fit at 390px.

### Design check (every variant)

Answer these for each variant and fix what fails:

1. Is the primary action clear within 3 seconds on mobile?
2. Are the user's top doubts (from Phase 3) answered before that action?
3. Is the first mobile screen showing what matters most?
4. Can one element be removed without weakening the variant? If yes, remove it.
5. Is it still clearly different from the other variants at a glance?

Bold variants: replace questions 1 and 3 with "Can the user clearly complete the job
and remove the Barrier?" The action may not be a button or above the fold if the variant explains why. Also
re-run the distance test on the built result: if it reads as today's page restyled, say so in the table
rather than calling it bold. In `protoCheck()` results, a bold variant's `aboveFold: false` is not a failure
by itself.

Free variants: use the bold questions, then add: Does the first screen answer the user's first question?
Does at least one element show data today's page hides? Does every state work (empty, no match, after the
main action, error, mobile)? Are there keyboard shortcuts the brief did not ask for? If so, remove them.

Then the light craft checklist: concentric radii, shadows vs borders used for the right job,
`text-wrap: balance`/`pretty`, tabular numbers on changing figures, 40px+ hit areas, visible focus states,
icons colored via `currentColor`, any motion `ease-out`, sub-300ms, interruptible, with
`prefers-reduced-motion` handled. Fix in Tailwind first, in the project's tokens.

## Phase 6 — Verify and hand off

Open the harness (MAMP: `/prototypes/<slug>/`). If `_kit/build.css` is missing or stale, ask the user to run
the watch command above first. Do not run lint unless asked.

By default, check the PHP render of each `?v=<n>` with `curl -s`. Check the HTTP response and look for
`Fatal error|Warning:|Notice:|Deprecated:` in the body. Fix render failures before sharing the picker
for manual review. Report the PHP render result.

### Browser verification on request

Run these checks when the user asks to `verify` or explicitly requests browser checks. For a standalone
verification request, open the existing prototype and run only the requested checks.

**Browser: Chrome DevTools MCP only** (`mcp__chrome-devtools__*`). Open one tab with `new_page` and
`isolatedContext: "ui-explore"` to keep the user's cart session separate. If Chrome DevTools is
unavailable, report the browser checks as skipped.

1. At 390×844 (mobile, touch) and 1280×900, run `async () => protoCheckAll()` for all variants or
   `() => protoCheck()` on the requested `?v=<n>` for a single variant. Check horizontal overflow,
   runtime errors, primary action placement, picker, toggles, headings, duplicate IDs, and missing alt
   attributes. Use `data-proto-primary` when the main action is not a `button-primary`.
2. For each checked variant with JS behavior, drive its main interaction and read the resulting state.
   If the action navigates, read `location.href` in a separate call. Fix failures and recheck the affected
   variants. An axis that intentionally puts the primary action below the mobile fold should explain why.
3. Take one mobile viewport screenshot when requested (`verify visual`) or when the JSON cannot explain
   a failure.

Hand off using [SKILL.md](SKILL.md#response) and let the user choose a variant.

## Phase 7 — Iterate or promote

Iterate (stays in `prototypes/<slug>/`, production untouched):

- `pin <name>`: keep the variant in the picker across rounds as a base or a comparison. Pinned variants come
  first in `$variants`; note them in the `index.php` docblock.
- `drop <name>`: delete the variant's file, its entry in `$variants`, and data only it used.
- `riff <name>`: build a new set diverging around that variant; name riffs after the change
  ("Urgency", "One Action"), files `<base>-<change>.php`. Unpinned variants from the previous round are
  dropped unless the user says otherwise.
- `mix <name> + <name>`: one new variant combining named parts of each, stated explicitly.

Promote (production):

- `keep <name>`: **replace the original piece in place.** The prototype's `index.php` docblock names its
  `Source` (page and piece). Change only that piece's markup in the source template; keep its data and
  state logic, and map the variant's static data back onto the real data. Before editing, list the
  production files you will change and wait for the user's go-ahead.
- `keep <name> as new`: create a new template beside the original instead, following the project's variant
  pages (`<page>-2.php`, as with `product-2.php`), and add it to `includes/demo-pages.php`. Use this when
  the user wants to compare against the live version or show a client.

For both: follow AGENTS.md strict rules (components, tokens, CSS file locations, change notice). Move any
`variant.css` rules into the right production CSS file only with approval, and replace placeholder blocks
with real assets or the user's chosen images. Complete the design-system check below, remind the user
to run `npm run build:css` or `watch:css` if Tailwind classes, tokens, or CSS changed, then delete `prototypes/<slug>/` and its `@import` line in
`_kit/prototype.css` unless asked to keep it. Never delete `_kit/`.

Free variants: the off-styleguide exception ends at `keep`. Before editing production, map the variant's
visual language to the design system, and list the new tokens, components, or patterns it would need. The
user then chooses: translate it onto existing components, or approve the new pieces first (AGENTS.md
approval for new CSS). Never move the variant's scoped `<style>` block into production as it is.

### Design-system check on promotion

1. Consult the relevant `/design` examples and their source components. Map the selected layout and
   interactions to existing components, documented sizes and variants, and theme tokens.
2. Replace prototype-only styling with existing utilities and tokens where possible. Remove component
   overrides for typography, padding, radius, and colors. If a pattern is missing, propose the smallest
   extension before implementing it and follow the approval rules for new CSS.
3. Review the changed markup against the component APIs and check that production data and state
   handling still fit those APIs. Report the components, variants, or tokens substituted during promotion.
