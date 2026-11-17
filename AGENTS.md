# AGENTS.md

Production-grade PHP + Tailwind project. Priorities: maintainability, readability, accessibility, consistency.

Rules come in three tiers:
- **Strict**: never break without explicit user permission.
- **Default**: follow unless there is a clear reason not to; if you deviate, say why.
- **Creative latitude**: use your judgment and propose better ideas.

---

## Strict — Delivery

- Implement what is requested. Keep diffs small and scoped; no unrelated rewrites or broad refactors.
- No breaking changes. Keep existing structure, APIs, component APIs, and array values/order stable.
- Never run build, compile, lint, or CSS build unless explicitly asked.
  When asked to verify: run only relevant checks and report what was verified, commands run, and failures/gaps.
- No new dependencies unless asked.
- When updating reusable components: implementation → call sites (if needed) → demos (if needed) →
  Tailwind config (only if required). Report what changed.
- If Tailwind classes, theme tokens, or CSS files change, remind the user to run CSS compile/watch.

## Strict — CSS & JS File Management

- Tailwind utilities first. Extract to CSS only when necessary; no duplicate logic between Tailwind and CSS.
- Component CSS lives in `assets/css/components/<component>.css`, imported through `assets/css/app.css`.
- Shared tokens, typography, and layout helpers live in `assets/css/foundations.css`.
- Preserve import order and cascade layers. Scope styles to component blocks. Remove obsolete CSS when
  markup changes.
- New CSS rules/files need explicit user approval (except prototypes, see below).
- **Change notice**: before adding CSS or JS (new files, additions, inline styles/scripts), tell the user
  which files change, what the code does, and why. Reuse existing utilities/behavior first. The notice is
  informational; continue unless the user asked to approve first. Moving code unchanged needs only a brief note.
- JS hooks use `.js-component-block-name` and go last in the `class` attribute
  (a single-class element may use the hook alone).

## Strict — Formatting

- 2 spaces, never tabs.
- Align `=` and `=>` when grouped. Align closing braces.
- Lines ~100–120 chars. Multi-line arrays/objects when needed. Trailing commas where valid.

## Strict — Design System

- `/design` and its source components are the source of truth. Reuse components with documented sizes/variants.
- Do not override component typography, padding, radius, or colors. No arbitrary font sizes; use tokens.
- If a pattern is missing, propose the smallest extension before implementing it.

---

## Default — Code & Markup

- PHP: `snake_case`. Page templates set `$page_title` and `$page_current`.
- PHP views: declare static data and component config arrays in one PHP block at the top; keep markup below
  easy to scan. Arrays that depend on loop/render-time state stay beside the code using them.
- Use `component(...)` from `includes/functions.php`. Icons: see `docs/conventions-icons.md`.
- Prefer static semantic HTML. No dynamic tag rendering (`<?= $*_tag; ?>`).
- Keep business logic out of UI; separate UI, state/data, logic, utilities.
- Small, single-purpose functions; guard clauses over deep nesting; no premature abstractions.
- Class naming and Tailwind ordering: read `docs/conventions-classes.md` before writing markup.
  Summary: descriptive class first (`card card-summary`, `card-label`), utilities in a consistent order,
  JS hook last. Do not rename or reorder unrelated existing classes.
- Ask only when a choice materially changes the outcome; otherwise state the assumption and proceed.

## Copywriting

- Dashboard copy: follow `docs/copywriting-dashboard.md`.
- Public/patient-facing copy: follow `docs/copywriting.md`.
- Apply only to copy within the requested scope.

---

## Creative Latitude

- Layout, composition, spacing rhythm, content order, and grouping within the requested scope.
- Suggesting better UX, copy, accessibility improvements, or component variants (propose, don't silently expand scope).
- Adding variables, loops, or small helpers when they make the requested change clearer or safer.

### Prototype Exploration

Inside an isolated prototype surface you may freely change markup, content order, layout, grouping, and
utility classes, and add prototype-specific CSS after a change notice (no separate approval).
- Constraints given in the request override this freedom and are strict for that prototype
  (e.g. "reuse existing navbar and footer", "keep page layout, explore content only").
- Keep typography tokens and design-system component styles.
- Keep prototype CSS isolated from production and shared components.
- Do not touch production during exploration. Integrate only the variant the user selects, following the
  design system closely; the exploration exception ends at integration.

## Documentation (Only When Needed)

- JS: non-trivial behavior → purpose + required DOM hooks.
- PHP: reusable/changed components → Component, Purpose, Structure, Data.
- CSS: non-obvious patterns only.
