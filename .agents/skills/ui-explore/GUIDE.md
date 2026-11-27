# Prompt guide

Load this only for `/ui-explore guide`. Do no recon, read no project files, and load no other skill file.
Reply in the user's language; keep keywords (`brainstorm`, `ask+`, `bold`, `free`, `x5`, `refs:`) as written.

## `guide` on its own

Show the template, the fields table, and two examples below, then stop.

```
/ui-explore <mode> <piece> at <url> — <problem or goal>. <ask|ask+> <safe|mixed|bold|free> <xN> [refs: <links/paths>]
```

| Field | Example | Why it matters |
| --- | --- | --- |
| Mode | `brainstorm` · `build` | Ideas only, or working variants. Default: brainstorm |
| Piece | "product list", "category filter", "order card" | One piece per run; skips the scoping search |
| URL | `http://localhost/wireland/shop/` | Recon reads the rendered page |
| Problem or goal | "users can't tell which product fits their hair problem" | Becomes the Barrier and the Job; shapes every direction |
| `ask` / `ask+` | `ask+` for client work | Interview before directions (4 or 7 questions) |
| Range | `safe` · `mixed` · `bold` · `free` | How far directions go. Default: mixed (one bold). `free` leaves the styleguide: one finished direction around the user's decision |
| Count | `x5` | Directions. Default 3; build caps at 5 |
| Refs | `refs: prototypes/inspirations/landing (hims, manual-co)` | Reference mode; name files to avoid a folder scan |

Examples:

```
/ui-explore brainstorm product list at http://localhost/wireland/shop/ — users can't tell which product fits
their hair problem, so they leave without buying. ask bold x5
```

```
/ui-explore brainstorm product card at http://localhost/wireland/shop/ ask+
```

```
/ui-explore build review queue at http://localhost/wireland/dashboard/workflow-list/ — doctors must decide
which case to act on next and what it needs, without opening each one. free
```

Next rounds in the same session: `build 2,4` · `riff <name> bold` · `mix <a> + <b>` · `pin` / `drop` / `keep` ·
`usage`.

Tips: start a new session per exploration (smaller context, lower cost); if you already know the barrier,
write it in the prompt so `ask` skips that question.

## `guide <rough request>`

Rewrite the user's request into the template:

1. Fill each field from their words. Do not invent a problem or goal.
2. Show the rewritten prompt in one code block, ready to copy.
3. Under it, list only the fields that are missing or guessed, one line each, with why it matters
   (e.g. "Problem: not given — without it, directions are guesses about why users struggle").
4. Ask once: run it as written, or adjust first. If a field is missing, suggest `ask` or `ask+` instead of
   asking the user to fill it by hand.

Example: `guide buat explore for http://localhost/wireland/shop/ brainstorm & ask+ dulu` →

```
/ui-explore brainstorm <piece> at http://localhost/wireland/shop/ — <problem or goal>. ask+ mixed
```

- Piece: missing — the whole page means the skill picks one piece itself; name it to save a step.
- Problem or goal: missing — `ask+` will ask about it (Barrier), so this can stay empty.
- Range: not given — defaults to `mixed` (one bold direction).
