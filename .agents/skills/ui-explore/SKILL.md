---
name: ui-explore
description: UI/UX exploration for this project. Brainstorms distinct UX directions for a screen or component, or builds them as working prototype variants behind a live picker. Works from link/screenshot references or from a fresh brief, and integrates the chosen variant using the project design system.
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

Read only the relevant part of [BUILD.md](BUILD.md): Rules and Phases 5–6 for build, Phase 6 for
standalone `verify`, or Phase 7 for iteration and promotion. Skip it in Brainstorm mode.

For `build 1,3` after brainstorm, reuse the chosen directions, brief, assumptions, and reference notes.
Go straight to build after targeted recon for any component API, data, or state details still needed.
Revisit a direction only if the brief changed or an implementation constraint affects it.

## Hard Rules

1. **Divergence over decoration.** Every direction differs on a named axis (see Axes). Two options that
   differ only in color, copy, or spacing are one option. Cut or replace it.
2. **References are studied, not copied.** Take patterns (structure, hierarchy, interaction model, flow,
   motion idea), never a brand's look: no copied logos, copy, imagery, brand colors, or pixel-for-pixel
   layouts. Every variant is rebuilt on this project's design system.
3. **Native to the product.** Directions use the `/design` components, theme tokens, and typography. No
   arbitrary font sizes, no overriding component typography, padding, radius, or colors (AGENTS.md strict).
   If a direction needs a missing pattern, name the smallest extension and keep it prototype-only.
   Exception: bold directions may compose new patterns from existing components (see Range below).
   `free` lifts this rule inside the prototype only, and only when the user's brief says `free`.
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

Use only the steps needed to resolve missing context. In Brainstorm mode, skip recon when the brief
supplies the UI, user problem, and relevant constraints. In Build mode, confirm the component APIs,
data, and states needed for implementation using context already gathered where possible.

Read rendered content and targeted excerpts. Do not read whole page templates.

1. **What the user sees**: `php prototypes/_kit/page-text.php <localhost url>` prints the rendered page's
   visible text without navbar, nav, and footer (~2–4k chars). It shows content, copy, the current state,
   and, where the page has a preview switcher, the list of states.
2. **Which components**: `grep -n "component('" <page>.php` (and `section('`). One line per component.
3. **Component APIs**: print only the docblocks of those components:
   `sed -n '/\/\*\*/,/\*\//p' views/components/<name>.php`. Never read component bodies.
4. **States** (only if the piece changes by state and step 1 did not list them): grep the page for its
   state list (e.g. `statuses`, `preview_state`) and read those lines only, not the logic around them.
5. **Sample data**: grep names, prices, and people from `includes/*-data.php`; do not read whole data files.
6. **Product and copy**: read the relevant section of `docs/directions.md` when the decision depends on a
   product goal or KPI. When writing or changing copy, read the relevant section of the public or
   dashboard copywriting guide. Find the section by its heading.

`AGENTS.md` is already in context. Read `docs/conventions-classes.md` before writing markup, once per session.
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

**Build assumptions.** Whatever you inferred instead of being told (who the user is, their
situation, the one action, how far to push) goes in the `Assumptions` block at the top of the output, one
line each, marked with its source (`docs/directions.md`, the current page, or `guess`). The user corrects
them in one reply instead of discovering a wrong premise in the directions.

**Range.** Default to `mixed`: use directions within the current layout and interaction model plus
exactly one direction that changes at least two of the interaction model, the unit of content, the
primary action, or the content strategy. Name the convention that direction breaks. It may compose
existing components into a new prototype-only pattern. In `safe`, stay within the current layout and
interaction model. In `free`, leave the design system and build one finished direction around the user's
decision; never infer `free`. Load [EXPLORE.md](EXPLORE.md) after recon only for `ask`, `ask+`, or explicit
`bold` or `free`. If an interview changes the range, use the answer.

### Phase 4 — Choose directions

Default **3**; up to 5 on request (`x5`). Brainstorm mode may list up to 6 when the space is wide.

Give each direction a distinct UX axis and a descriptive name. Identify the relevant `/design`
components, credit reference patterns, and flag new patterns. For bold directions, name the convention
broken and label any provocation. If two directions differ only cosmetically, combine them.

Build mode continues with [BUILD.md](BUILD.md) (Rules and Phases 5–6).

## Response

- **Brainstorm:** Use one numbered bullet per direction with the idea, when it fits, and the main
  trade-off. Include assumptions that affect the choice. Add a wireframe when requested or when it
  clarifies layout or hierarchy. Let the user choose which directions to build.
- **Build:** Share the picker link and keys, one line per variant with its trade-off, the PHP render
  result, and any open issues. Include browser results when requested.
- **Keep:** State what was promoted, the design-system and production checks performed, and any
  pending steps.

Expand on request.

## Invocation

| Invocation | Behavior |
| --- | --- |
| `<brief>` | Detect mode and condition, run the workflow |
| `brainstorm <brief>` | Ideas only, stop after Phase 4; only assumptions that could change the choice |
| `<brief> ask` | Ask 4 questions (user, action, barrier, range) after recon, before choosing directions |
| `<brief> ask+` | The 4 above plus feel, must-not-change, avoid |
| `<brief> safe` / `mixed` / `bold` | Set the range directly (default `mixed`); `bold` applies the bold rules |
| `<brief> free` | Off-styleguide prototype: own visual language, one finished direction (`xN` for more) |
| `build <brief>` | Full workflow through the picker |
| `<brief> refs: <links/paths>` | Reference mode with those inputs |
| `<brief> x5` | That many directions (build caps at 5) |
| `build 1,3` | Build the numbered directions from the last brainstorm |
| `verify` / `verify <name>` | Run browser checks for all variants or one (BUILD.md Phase 6) |
| `riff <name>` / `mix <a> + <b>` | New round around a variant / a combined variant |
| `pin <name>` | Keep the variant in the picker for the next rounds (base or comparison) |
| `drop <name>` | Remove the variant from the prototype |
| `keep <name>` | Promote to production by replacing the original piece in place, then delete the prototype |
| `keep <name> as new` | Promote as a new template beside the original (`<page>-2.php`) |
| `usage` | Read Claude Code token usage on request (`python3 -I .agents/skills/ui-explore/scripts/usage.py --full`) |
| `guide` | Show the prompt template, keywords, and examples (no recon) |
| `guide <rough request>` | Rewrite the request into a complete prompt, flag missing fields, offer to run it |
