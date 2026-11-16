# AGENTS.md

## Purpose
Follow production-grade standards. Prioritize:
- maintainability
- readability
- accessibility
- consistency

Default:
- small, focused changes
- no unrelated rewrites
- preserve existing structure/APIs

---

## Working Mode

### Default (Build / Edit)
- Implement only what is requested.
- Inspect nearby patterns first.
- Keep diffs small and scoped.
- Do not run build/compile/lint.
- Do not refactor broadly.
- Suggest verification if relevant.

### Verification (Explicit Only)
Only when explicitly requested:
- verify, lint, compile, build, validate

- Run only relevant checks.
- Do not expand scope.
- Report:
  - what was verified
  - commands run
  - failures / gaps

---

## Core Rules
- No breaking changes unless asked.
- No large unrelated rewrites.
- No unnecessary dependencies.
<!-- - Reuse existing helpers/components first. -->
- Keep APIs stable.
- Prefer clarity over cleverness.
- Small, single-purpose functions.
- Avoid deep nesting (use guard clauses).
- Remove obvious duplication when touching code.
- No premature abstractions.

---

## Architecture
- Follow existing structure and naming.
- Keep business logic out of UI.
- Separate:
  - UI
  - state/data
  - business logic
  - utilities

---

## Component System
- Use helpers from `include/functions.php`:
  - `component(...)`

---

## SVG Icons
- Render icons using `svg('icon-name', 'tailwind classes')`.
- Icons are registered in `includes/svg.php`.
- Source SVGs: `node_modules/remixicon/icons/`.
- When adding an icon:
  1. Check whether it is already registered.
  2. If missing, find the exact Remix Icon SVG and register it
     following the existing format and accessibility attributes.
  3. Add the `svg(...)` call in the requested view.
- No need to inspect `includes/functions.php` unless changing
  the helper API or investigating a rendering issue.
- Preserve existing wrapper classes.
- Do not run build, compile, or lint unless requested.

---

## PHP Conventions
- Use `snake_case`.
- Page templates:
  - `$page_title`
  - `$page_current`
- In PHP view files, declare static data and component configuration arrays in one PHP block at the top,
  before HTML or component rendering. Keep the markup below easy to scan.
- Preserve array values, order, and existing component APIs when moving them. Leave arrays that depend on
  loop variables or render-time state beside the code that needs them.
- Follow global formatting rules.

---

## Formatting (Non-Negotiable)
- 2 spaces. No tabs. Never mix.
- Consistent indentation.
- Align `=` and `=>` when grouped.
- Align closing braces.
- Prefer 100–120 char lines.
- Use multi-line arrays/objects when needed.
- Use trailing commas where valid.

---

## Template Guardrails (Non-Negotiable)
- No dynamic tag rendering (`<?= $*_tag; ?>`).
- Use static semantic HTML unless asked.
- Avoid new variables, loops, helpers, or flexible APIs unless required to implement or fix the requested behavior safely.
- Only implement what is requested.
- Do not modify existing classes unless asked.
- If assumptions are needed, ask first.

---

## Descriptive Class Names (Non-Negotiable)

Use a simplified BEM-inspired convention with short, local names.
Do not use strict BEM syntax (`__` or `--`).

### Base Components and Variants
- Name generic UI components by their role: `card`, `field`, `modal`.
- Add a variant only when a meaningful distinction is needed.
- Include both base and variant classes: `card card-summary`.
- Name parts after the base component:
  - Use `card-content`, `card-label`, `card-value`, `card-action`.
  - Avoid `summary-content`, `summary-card-content`, `card-summary-content`.

### Entities and Collections
- Use entity names for distinct entity components:
  - `patient`, `patient-name`, `patient-avatar`.
  - `order`, `order-number`, `order-status`.
- For an entity-specific card, use `card card-patient`.
  Use `card-*` for card structure and `patient-*` for entity details.
- Name collections by their local role or contents, such as `patients` or `flow-presents`.

### Sections and Nested Components
- Use `section` for section roots.
- Use `section-header`, `section-banner`, or `section-subheader` for section parts.
- Nested components start their own naming scope.
  A field inside a card uses `field-label`, not `card-field-label`.
- Do not repeat page names, filenames, variants, or ancestor chains in descendant names.
- Avoid standalone names such as `title`, `content`, or `image`.
  Use the nearest component prefix.

### Coverage and Class Order
- Give every section and primary structural element a descriptive class,
  including wrappers, headers, titles, content areas, images, prices, controls, and actions.
- Descriptive classes may be reused across sections and need not have CSS rules.
- Place descriptive classes first, followed by Tailwind utilities.
- Keep JS hook classes last.
- Apply to new or explicitly requested markup changes only.
  Do not rename unrelated existing classes.

---

## JS Class Hooks (Non-Negotiable)
- All JS-related class hooks must use this format:
  - `.js-component-block-name`
- JS hook classes must be placed at the end of the `class` attribute (not at the beginning or middle).
- Exception:
  - If the element has a single class only, the JS hook can be that single class.

---

## Tailwind Class Order and Formatting (Non-Negotiable)
- Order classes consistently:
  descriptive → position → layout → size → spacing → typography → appearance → behavior/motion →
  states → responsive → JS hooks.
- Position: `relative`, `absolute`, inset utilities, z-index.
- Layout: `flex`, `grid`, direction, alignment, gap.
- Size: width, height, min/max dimensions, aspect ratio.
- Spacing: margin, padding.
- Typography: text alignment, font family, font size, font weight, line height, letter spacing.
- Appearance: radius, border, background, text color, shadow.
- Behavior/motion: overflow, cursor, transitions, duration, easing.
- Keep related utilities together, such as `px-5 py-4` and `border border-zinc-200`.
- Keep short class attributes on one line. For long attributes, use this multiline structure:
  - Base classes first, starting with descriptive classes.
  - State variants on a separate line, such as `hover:`, `focus-visible:`, and `disabled:`.
  - Responsive variants on separate lines, one breakpoint per line: `sm`, `md`, `lg`, `xl`, `2xl`.
  - JS hooks on the final separate line, inside the `class` attribute.
- Within state and responsive groups, follow the same utility order.
- Keep combined responsive/state variants on their breakpoint line, such as `md:hover:bg-zinc-100`.
- Indent continuation lines 2 spaces beyond the line containing `class`.
- Apply to new or explicitly requested markup changes. Do not reorder existing classes unless asked.

---

## CSS and JS Change Notices
- Before adding CSS or JavaScript code for a requested change, notify the user in commentary.
- State which files or components will change, what the added code will do, and why it is needed.
- This applies to new files and additions to existing files, including inline styles or scripts in templates.
- Reuse existing utilities, components, and behavior before adding new CSS or JavaScript.
- A notice is informational; continue within the authorized scope without waiting for approval unless the user
  explicitly asks to approve changes first.
- Moving existing code without changing its styling or behavior only requires a brief notice about the move.

---

## Design System — Mandatory

- Treat `/design` and its source components as the source of truth.
- Reuse existing components with their documented sizes and variants.
- Do not override component typography, padding, radius, or colors.
- Use existing typography tokens; no arbitrary font sizes.
- Use Tailwind utilities for page layout.
- New CSS rules/files require explicit user approval, except within isolated prototype exploration as defined below.
- If a required pattern is missing, propose the smallest extension first.
- Skills and prototypes must follow these rules.

### Prototype Exploration

- Within an isolated prototype surface, freely explore markup, content order, layout, grouping, and utility classes.
  This overrides the restrictions on changing existing classes and introducing layout patterns within that surface.
- Keep existing typography tokens and design system component styles.
- Prototype-specific CSS is permitted after the required change notice, without separate approval.
  Keep it isolated from production styles and shared components.
- Do not change production during exploration. Integrate only the variant selected by the user.
- When promoting a selected variant, follow the existing design system as closely as possible: reuse its components,
  documented variants, tokens, and conventions. The exploration exception ends at production integration.
- If the selected design needs a design system extension, propose the smallest extension before implementing it.
- All other project rules still apply.

---

## Styling
- Use Tailwind as default.
- Prefer Tailwind utility classes.
<!-- - Prefer utility classes + existing components. -->
- Extract to CSS only when necessary.
- Avoid duplicate logic between Tailwind and CSS.
- No unnecessary CSS.
- Remove obsolete CSS when markup changes.
- Scope styles to component blocks.
- Keep component CSS in `assets/css/components/<component>.css` and import it through `assets/css/app.css`.
- Keep shared tokens, typography, and layout helpers in `assets/css/foundations.css`.
- Preserve import order and cascade layers when moving styles.
- Avoid modifying existing class values unless required to implement or fix the requested change.
- Update Tailwind config only when required.
- Do not run CSS builds unless asked.
- If Tailwind classes, theme tokens, or CSS files change, remind the user to run CSS compile/watch.

---

## Component Changes
When updating reusable components:
1. Update implementation.
2. Update call sites only if needed.
3. Update demos only if needed.
4. Update Tailwind config only if required.
5. Run verification only if asked.
6. Report changes.

---

## Copywriting

- Before writing or editing dashboard copy, read and follow `docs/dashboard-copywriting.md`.
- For public website and patient-facing copy, read and follow `docs/copywriting.md`.
- Apply the guidelines only to copy within the requested scope.

---

## Documentation (When Needed)
Only when necessary:
- JS: non-trivial behavior → purpose + required DOM hooks
- PHP: reusable/changed components → Component, Purpose, Structure, Data
- CSS: only non-obvious patterns

<!-- Temporarily disabled while establishing the wireframe design system.

## UI Guardrails

- Always reuse existing components in `/views/components` first.
- Treat existing components as the source of truth for UI structure and styling.
- Do not invent new visual patterns, layouts, variants, or interaction styles without explicit approval.
- Prefer existing helper APIs (`component(...)`) over raw custom markup.
- Before implementation, inspect relevant existing components and align with their naming, spacing, and behavior.
- If existing components are not enough, stop and propose the smallest safe extension before writing code.
- Do not redesign, restyle, or “improve” existing UI unless explicitly requested.

# AGENTS.md

## Design System Priority
- Follow the existing design system and UI patterns already present in this repository.
- Reuse existing components before creating new UI.
- Do not introduce new visual patterns, spacing rules, radius, shadows, or interaction styles unless explicitly requested.
- Match the current typography, spacing rhythm, border treatment, and component conventions.

## Component Reuse Rules
- Check `/views/components` first before writing new markup.
- Prefer existing helpers:
  - `component(...)`
- If an existing component is close, extend its API only if explicitly requested.
- If no existing component fits, stop and propose the closest reusable options first.

## Page Building Rules
- When creating a new page, assemble it from existing sections/components as much as possible.
- Keep the page visually consistent with existing pages.
- Do not redesign the system while implementing the page.
- Do not invent new card, button, form, badge, table, or nav styles without approval.

## Styling Rules
- Use Tailwind CSS as the primary styling system.
- Do not replace existing classes or tokens unless required by the task.
- Respect existing spacing scale, container width, and responsive behavior.
- Avoid one-off visual styling if an existing utility pattern already exists.

## Output Rules
- Before coding, inspect relevant existing pages/components.
- State which existing components/patterns will be reused.
- Do not run CSS compile/build unless explicitly asked; remind the user when CSS needs recompiling.
- If the design system is insufficient, pause and propose options instead of improvising.

-->
