# Build mode

Load this only in Build mode, after Phase 4 of [SKILL.md](SKILL.md) has a set of directions.

## Rules

1. **Never touch production.** Write only inside `prototypes/<slug>/`, plus one `@import` line in
   `prototypes/_kit/prototype.css` when the prototype has a `variant.css`. Nothing in production imports
   from `prototypes/`. Integration happens only after the user picks (Phase 7).
2. **Every variant fully works.** Real interactions, real states, realistic content. No dead buttons.
3. **The kit is chrome, not a contestant.** Use `prototypes/_kit/` as is. Do not open, restyle, or rewrite
   its files, and do not read older prototypes for the harness pattern.
4. **Design check on every variant, full polish on the winner.** Exploration decides direction, so every
   variant gets the light checks below. The full `make-interfaces-feel-better` pass runs once, on `keep`.

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

### Images: placeholder blocks only

Do not use image assets or generate images. Every image slot is a placeholder block with the real aspect
ratio and a label naming the intended image, following the project pattern
(`aspect-square rounded-lg bg-zinc-300` + label, see `views/pages/product-2.php`). If a variant depends on a
specific image (e.g. before/after photos), flag it in the result table.

While building:

- **Change notice first** (AGENTS.md): before writing `variant.css`/`prototype.js` or inline code, tell
  the user which files, what the code does, and why. Continue unless they asked to approve first.
- Tailwind utilities first; `variant.css` only for what utilities cannot express. Scope its selectors to
  the prototype's own classes.
- Render one variant at a time, full size, inside realistic page context (navbar, neighbors, footer as
  needed). Never judge at thumbnail size.
- Variant swap is a plain reload to `?v=<n>`, no animation.
- Keep `$variants` labels short (one word, about 10 characters): 4–5 long names overflow the picker at 390px.
- Formatting follows AGENTS.md: 2 spaces, aligned `=`/`=>`, JS hooks last in `class`.

### Design check (every variant)

Do not load `make-interfaces-feel-better` here. Answer these for each variant and fix what fails:

1. Is the primary action clear within 3 seconds on mobile?
2. Are the user's top doubts (from Phase 3) answered before that action?
3. Is the first mobile screen showing what matters most?
4. Can one element be removed without weakening the variant? If yes, remove it.
5. Is it still clearly different from the other variants at a glance?

Bold variants (see EXPLORE.md, Range): replace questions 1 and 3 with "Can the user clearly complete the job
and remove the Barrier?" The action may not be a button or above the fold if the variant explains why. Also
re-run the distance test on the built result: if it reads as today's page restyled, say so in the table
rather than calling it bold. In `protoCheck()` results, a bold variant's `aboveFold: false` is not a failure
by itself.

Then the light craft checklist: concentric radii, shadows vs borders used for the right job,
`text-wrap: balance`/`pretty`, tabular numbers on changing figures, 40px+ hit areas, visible focus states,
icons colored via `currentColor`, any motion `ease-out`, sub-300ms, interruptible, with
`prefers-reduced-motion` handled. Fix in Tailwind first, in the project's tokens.

**Motion exception:** if a variant's axis is motion, load
[animations.md](../make-interfaces-feel-better/animations.md) for that variant only, since motion is what it
is testing.

## Phase 6 — Verify and hand off

Open the harness (MAMP: `/prototypes/<slug>/`). If `_kit/build.css` is missing or stale, ask the user to run
the watch command above first. Do not run lint unless asked.

**Browser: Chrome DevTools MCP only** (`mcp__chrome-devtools__*`); never use Playwright tools in this skill.
Open one tab with `new_page` and `isolatedContext: "ui-explore"` (keeps the user's session cart untouched),
then reuse it: `emulate` with `viewport` `390x844x2,mobile,touch` or `1280x900x1`, `navigate_page`, and
`evaluate_script` for every check below. If Chrome DevTools is unavailable, skip steps 2–3, say so in the
hand-off, and do not fall back to another browser tool.

1. **PHP render**: `curl -s` each `?v=<n>` and grep for `Fatal error|Warning:|Notice:|Deprecated:` (exact
   strings, so class names like `color-warning` don't match).
2. **Scripted check**, no screenshots, all variants in one call per viewport: open `?v=1`, set the viewport
   to 390×844 (mobile, touch), and run one evaluate with exactly `async () => protoCheckAll()`; then set
   1280×900 (no reload needed) and run it again. Both are defined by `_kit/check.js`; never open that file.
   Each variant loads in an off-screen iframe sized to the viewport and returns `protoCheck()`: `overflowX`,
   runtime `errors`, the primary action and whether it is `aboveFold`, `picker` (wired and inside the
   viewport), broken `toggles`, `h1` count, `duplicateIds`, and `imagesNoAlt`. Mark a variant's main action
   with `data-proto-primary` if it is not a `button-primary`. Use `() => protoCheck()` on a single variant
   only to re-check one fix.
3. **Interaction check**: every variant with JS behavior (`prototype.js`) gets one evaluate on its own
   `?v=<n>` that drives its main interaction (select, filter, swap, total) and returns the resulting state,
   so wrong totals, dead controls, and broken focus are caught. Static checks never replace this. For
   actions that navigate (e.g. add to cart), read `location.href` in a separate call afterwards.
4. **Fix and re-run** any failure. A primary action below the fold on mobile fails the design check unless
   the variant's axis explains it; say so in the table.
5. **Screenshots only when required**: a failure that cannot be understood from the JSON, or the user asks
   (`verify visual`). Then take one viewport screenshot at mobile width, never full-page.

Present the result table, the URL, the picker keys, and a suggested next step. Then stop: the choice is the
user's.

```
| # | Variant | Axis | Source | When it's the right choice | Its cost |
| - | ------- | ---- | ------ | -------------------------- | -------- |

Design notes: <what the design check changed, per variant, one line each>
Open: <URL>  ·  Keys: 1–N or ←/→ to switch

Suggested next:
- pin <name>: <why it earns another round or stays as the comparison>
- drop <name>: <why it no longer teaches anything>
- keep <name>: only when one variant is clearly solid (passes every check, no open questions, no flagged
  images); otherwise say what is still open
```

Suggestions are reasons tied to the brief, KPIs, and checks, never taste alone. Suggest at most one `keep`.

End the hand-off (and the `keep` report) with the run's token usage, read from the session transcript, never
estimated. Run from the project root and paste its output as is:

```
python3 -I .agents/skills/ui-explore/scripts/usage.py --turns 1
```

`--turns 1` counts from the user message that started this run; use `--since-text "<words from it>"` when
the run spanned several messages. `usage` on its own runs it with `--full`.

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
with real assets or the user's chosen images. Run the full polish pass below, remind the user to run
`npm run build:css` or `watch:css`, then delete `prototypes/<slug>/` and its `@import` line in
`_kit/prototype.css` unless asked to keep it. Never delete `_kit/`.

### Full polish pass (winner only)

Load [make-interfaces-feel-better](../make-interfaces-feel-better/SKILL.md) and run its checks on the
integrated variant. Open only the sub-guides that match what it contains:

| Variant contains | Read |
| --- | --- |
| Headings, body copy, prices, counters | [typography.md](../make-interfaces-feel-better/typography.md) |
| Cards, nested radii, shadows, images, small hit targets | [surfaces.md](../make-interfaces-feel-better/surfaces.md) |
| Enter/exit, hover, press, accordions, step changes | [animations.md](../make-interfaces-feel-better/animations.md) |
| Icons, icon state changes | [icons.md](../make-interfaces-feel-better/icons.md) |
| Any transition | [performance.md](../make-interfaces-feel-better/performance.md) |

Walk every state (hover, focus, active, empty, loading, error where relevant) and report the fixes applied.
