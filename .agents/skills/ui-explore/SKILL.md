---
name: ui-explore
description: UI/UX exploration for this project. Brainstorms distinct UX directions for a screen or component, or builds them as working prototype variants behind a live picker. Works from link/screenshot references or from a fresh brief, and gives the chosen variant a full make-interfaces-feel-better polish pass.
disable-model-invocation: true
---

# UI/UX Exploration

## Initial Response

When invoked without a brief, respond only with:

> Ready to explore. Tell me the piece of UI, and optionally: references (links, screenshots, or a folder in
> `prototypes/inspirations/`), how many variants, and whether you want **ideas only** or **built variants**.
> Not sure how to phrase it? Use `/ui-explore guide`, or `/ui-explore guide <your rough idea>`.

When the first word after `/ui-explore` is `guide`, load only [GUIDE.md](GUIDE.md) and follow it. Do no
recon and load no other file.

## What this skill does

Two goals, one workflow:

| Mode | Output | Code? |
| --- | --- | --- |
| **Brainstorm** | A divergence map of UX directions with tradeoffs, ready to pick from | No |
| **Build** | Working variants in `prototypes/<slug>/` behind the picker, ready to flip through | Yes (prototype only) |

Two input conditions, detected from the brief:

| Condition | Trigger | Where ideas come from |
| --- | --- | --- |
| **With references** | URLs, screenshots, image paths, or `prototypes/inspirations/<folder>` | Patterns pulled out of the references, then pushed further |
| **Fresh** | No references given | The product's goals, users, and context, explored across axes |

Pick the mode from the user's words: "brainstorm", "ideas", "explore options", "what could this be" →
Brainstorm. "build", "prototype", "variants", "make versions" → Build. If unclear, default to Brainstorm and
offer to build the chosen directions at the end. A Brainstorm can always roll into Build (`build 1,3`).

Build mode adds [BUILD.md](BUILD.md) after Phase 4. Do not load it in Brainstorm mode.

## Hard Rules

1. **Divergence over decoration.** Every direction differs on a named axis (see Axes). Two options that
   differ only in color, copy, or spacing are one option. Cut or replace it.
2. **References are studied, not copied.** Take patterns (structure, hierarchy, interaction model, flow,
   motion idea), never a brand's look: no copied logos, copy, imagery, brand colors, or pixel-for-pixel
   layouts. Every variant is rebuilt on this project's design system.
3. **Native to the product.** Directions use the `/design` components, theme tokens, and typography. No
   arbitrary font sizes, no overriding component typography, padding, radius, or colors (AGENTS.md strict).
   If a direction needs a missing pattern, name the smallest extension and keep it prototype-only.
   Exception: bold directions may compose new patterns from existing components (EXPLORE.md, Range, rule 6).
4. **Realistic content.** Product-shaped copy, names, prices, and states from the project's data files
   (`includes/*-data.php`, `includes/store.php`). No lorem ipsum. Copy follows `docs/copywriting.md`
   (public) or `docs/copywriting-dashboard.md` (dashboard).

## Axes

Use these to make directions genuinely different. Each direction takes a clear position on one or two.

| Axis | Ends of the range |
| --- | --- |
| Layout | Single column ↔ split ↔ grid ↔ stacked cards ↔ sticky rail |
| Density | Airy, editorial ↔ compact, scannable |
| Hierarchy | One hero action ↔ several equal paths |
| Disclosure | Everything visible ↔ progressive (tabs, accordions, steps) |
| Interaction model | Read and scroll ↔ choose and filter ↔ guided step-by-step ↔ direct manipulation |
| Trust/proof | Clinical and factual ↔ human and story-led |
| Personality | Quiet utility ↔ warm consumer ↔ bold editorial |
| Motion | Static ↔ functional transitions only ↔ staged entrance (infrequent moments only) |

## Workflow

### Phase 1 — Scope

One piece per run. If the brief spans a whole page or flow, pick the highest-leverage piece, say which and
why, and list the rest as follow-up runs. Restate the brief in one sentence: what it is, where it lives,
who uses it, what it must achieve (tie to `docs/directions.md` goals/KPIs when relevant).

### Phase 2 — Recon

Recon reads what the user sees, not how the page computes it. Do not read whole page templates.

1. **What the user sees**: `php prototypes/_kit/page-text.php <localhost url>` prints the rendered page's
   visible text without navbar, nav, and footer (~2–4k chars). It shows content, copy, the current state,
   and, where the page has a preview switcher, the list of states.
2. **Which components**: `grep -n "component('" <page>.php` (and `section('`). One line per component.
3. **Component APIs**: print only the docblocks of those components:
   `sed -n '/\/\*\*/,/\*\//p' views/components/<name>.php`. Never read component bodies.
4. **States** (only if the piece changes by state and step 1 did not list them): grep the page for its
   state list (e.g. `statuses`, `preview_state`) and read those lines only, not the logic around them.
5. **Sample data**: grep names, prices, and people from `includes/*-data.php`; do not read whole data files.
6. **Product and copy**: `docs/directions.md` and the matching copywriting doc. List headings first
   (`grep -n "^#"`) and read only the sections that bear on the piece.

`AGENTS.md` is already in context. Read `docs/conventions-classes.md` once per session, in Build mode only.
If the user's brief names the exact piece, skip Phase 1's search.

### Phase 3 — Gather inputs

**With references** — follow [REFERENCES.md](REFERENCES.md): capture each reference, break it into
patterns, and write a short pattern table before choosing directions.

**Fresh** — before choosing directions, write down:

1. The user's job on this piece in one line (e.g. "decide if this treatment fits me before booking").
2. The top 3 questions or doubts they arrive with.
3. The one action that matters most, and what success looks like.
4. Constraints: content that must appear, mobile-first needs, accessibility needs.

Then spread directions across the Axes table so each answers the job differently.

**Assumptions block (always).** Whatever you inferred instead of being told (who the user is, their
situation, the one action, how far to push) goes in the `Assumptions` block at the top of the output, one
line each, marked with its source (`docs/directions.md`, the current page, or `guess`). The user corrects
them in one reply instead of discovering a wrong premise in the directions.

**`ask`, `ask+`, and Range.** If the brief includes `ask` or `ask+`, or the range is `mixed` or `bold`
(default `mixed`), load [EXPLORE.md](EXPLORE.md) right after Phase 2 recon, before writing anything for
Phase 3: it holds the interview questions and the bold rules. Only a `safe` brief without `ask` skips it.

### Phase 4 — Choose directions

Default **3**; up to 5 on request (`x5`). Brainstorm mode may list up to 6 when the space is wide.

For each direction write:

- **Name**: describes the direction ("Guided", "Ledger", "Story-led"), never "Option A".
- **Axis**: its position in a phrase ("progressive disclosure, compact").
- **Idea**: 1–2 sentences on how it solves the job.
- **Source**: the reference pattern it borrows (by reference name), `ref + fresh`, or `fresh`.
- **Reuses**: the `/design` components it relies on; any missing pattern flagged (`New pattern`).
- **Bold only**: `Breaks: <convention>`, and `Provocation` where it applies.
- **Sketch**: an ASCII wireframe of the layout in a ```` ```text ```` block (rules below).

**Sketch rules.** A sketch shows structure, order, and the primary action, not styling.

- Mobile first: 36 chars wide inside the frame. Add a second desktop sketch (max 72 chars) only when the
  direction's Layout axis changes at desktop (split, grid, sticky rail).
- Box-drawing frame (`┌ ─ ┐ │ └ ┘`), top to bottom in reading order. No emoji or circled digits
  (`①`); they render double-width and break the frame. Mark the fold with `┄┄ fold ┄┄`
  when content order around it matters.
- Primary action as `[■ Label ]`, secondary as `[ Label ]`, links as `Label →`, inputs as `[________]`,
  images as `[ img ]`, chips/tabs as `(Tab)` with the active one `(●Tab)`.
- Real short copy from recon (names, prices, labels), not `xxx` or lorem.
- Label each block with its `/design` component on the right edge when it is not obvious (`‹card›`,
  `‹timeline›`); `‹new›` for a New pattern.
- Interaction that a static sketch cannot show goes in one `↳` line under the block (e.g.
  `↳ tap a step to expand; one open at a time`).

**Completion criterion:** every direction has a distinct axis and a sketch, and none differ only
cosmetically (if two sketches look alike, the directions are one option).

**Brainstorm mode stops here.** Present the divergence map and wait:

```
Brief: <one sentence>
Input: <references used | fresh>
Assumptions: (correct any line and I'll rerun the directions)
- User: <who, at what moment> (<source>)
- Job and doubts: <one line> (<source>)
- Action: <the one action> (<source>)
- Barrier: <what stops them today> (<source>)
- Range: <safe | mixed | bold> (<source>)
- Evidence: <photos, reviews, data assumed available or missing> (<source>)
Conventions: <3–5 shared conventions> (mixed/bold only)

| # | Direction | Axis | Idea | Source | Breaks | Wins when | Costs |
| - | --------- | ---- | ---- | ------ | ------ | --------- | ----- |

Sketches: one `### <#> <Direction>` heading per direction, each followed by its ```text wireframe.

Culled concepts (bold only): <the dropped one-liners, one line>

Patterns worth stealing (reference mode): <3–5 bullets, each tied to a reference>
Open questions: <only those that change the outcome>
Next: `build 1,3`, `riff 2`, or adjust the brief.
```

**Build mode continues** with [BUILD.md](BUILD.md) (Phases 5–7).

Suggest, don't decide: after a build, suggest `pin`/`drop`/`keep` with reasons (see BUILD.md Phase 6). In a
brainstorm, do not pick a favorite unless asked; then give a reason tied to the product's goals and
frequency of use, not taste alone. If two directions converge, cut one and say so.

## Invocation

| Invocation | Behavior |
| --- | --- |
| `<brief>` | Detect mode and condition, run the workflow |
| `brainstorm <brief>` | Ideas only, stop after Phase 4; inferred assumptions listed on top |
| `<brief> ask` | Ask 4 questions (user, action, barrier, range) after recon, before choosing directions |
| `<brief> ask+` | The 4 above plus feel, must-not-change, avoid |
| `<brief> safe` / `mixed` / `bold` | Set the range directly (default `mixed`); `bold` applies the bold rules |
| `build <brief>` | Full workflow through the picker |
| `<brief> refs: <links/paths>` | Reference mode with those inputs |
| `<brief> x5` | That many directions (build caps at 5) |
| `build 1,3` | Build the numbered directions from the last brainstorm |
| `riff <name>` / `mix <a> + <b>` | New round around a variant / a combined variant |
| `pin <name>` | Keep the variant in the picker for the next rounds (base or comparison) |
| `drop <name>` | Remove the variant from the prototype |
| `keep <name>` | Promote to production by replacing the original piece in place, then delete the prototype |
| `keep <name> as new` | Promote as a new template beside the original (`<page>-2.php`) |
| `usage` | Full token breakdown for this run (`scripts/usage.py --full`); builds end with a short one |
| `guide` | Show the prompt template, keywords, and examples (no recon) |
| `guide <rough request>` | Rewrite the request into a complete prompt, flag missing fields, offer to run it |
