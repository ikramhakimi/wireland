# Class Conventions

Read before writing or editing markup. Apply to new or requested markup only; do not rename or reorder
unrelated existing classes.

## Descriptive Class Names

Simplified BEM-inspired, short local names. No strict BEM (`__`, `--`).

### Base Components and Variants
- Name generic UI components by role: `card`, `field`, `modal`.
- Add a variant only for a meaningful distinction. Include base and variant: `card card-summary`.
- Name parts after the base: `card-content`, `card-label`, `card-value`, `card-action`.
  Avoid `summary-content`, `summary-card-content`, `card-summary-content`.

### Entities and Collections
- Entity components use entity names: `patient`, `patient-name`, `order-status`.
- Entity-specific card: `card card-patient`. `card-*` for structure, `patient-*` for entity details.
- Collections by local role/contents: `patients`, `flow-presents`.

### Sections and Nested Components
- Section roots use `section`; parts use `section-header`, `section-banner`, `section-subheader`.
- Nested components start their own scope: a field in a card uses `field-label`, not `card-field-label`.
- Do not repeat page names, filenames, variants, or ancestor chains.
- Avoid standalone `title`, `content`, `image`; use the nearest component prefix.

### Coverage
- Give sections and primary structural elements a descriptive class (wrappers, headers, titles, content,
  images, prices, controls, actions). They may be reused and need no CSS rule.

## Tailwind Class Order

descriptive → position → layout → size → spacing → typography → appearance → behavior/motion →
states → responsive → JS hooks.

- Position: `relative`, `absolute`, inset, z-index.
- Layout: `flex`, `grid`, direction, alignment, gap.
- Size: width, height, min/max, aspect ratio.
- Spacing: margin, padding.
- Typography: alignment, family, size, weight, line height, tracking.
- Appearance: radius, border, background, text color, shadow.
- Behavior/motion: overflow, cursor, transitions, duration, easing.
- Keep related utilities together (`px-5 py-4`, `border border-zinc-200`).
- Same order inside state and responsive groups.

## Multiline Class Attributes

Short attributes stay on one line. Long ones:
- Base classes first (descriptive first).
- State variants on their own line (`hover:`, `focus-visible:`, `disabled:`).
- One line per breakpoint: `sm`, `md`, `lg`, `xl`, `2xl`. Combined variants stay on their breakpoint line
  (`md:hover:bg-zinc-100`).
- JS hooks on the final line.
- Indent continuation lines 2 spaces beyond the line containing `class`.

```html
<button
  class="button button-primary flex items-center gap-2 px-4 py-2
    hover:bg-zinc-800
    md:px-5
    js-form-submit"
>
```
