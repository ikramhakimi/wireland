# SVG Icons

- Render with `svg('icon-name', 'tailwind classes')`.
- Icons are registered in `includes/svg.php`. Source SVGs: `node_modules/remixicon/icons/`.
- Adding an icon:
  1. Check whether it is already registered.
  2. If missing, copy the exact Remix Icon SVG and register it following the existing format and
     accessibility attributes.
  3. Add the `svg(...)` call in the requested view.
- No need to inspect `includes/functions.php` unless changing the helper API or debugging rendering.
- Preserve existing wrapper classes.

The `image-line`, `image-add-line`, and `user-line` entries use Solar Linear SVGs from
`node_modules/@solar-icons/static/dist/icons/linear/`. The registry sets their stroke width to 2
and appends caller classes to their `solar-*` class.

[Solar Icons by 480 Design](https://solar-icons.dev/) are licensed under
[CC BY 4.0](https://creativecommons.org/licenses/by/4.0/).
