# Working from references

Use this when the brief includes links, screenshots, image paths, or a folder such as
`prototypes/inspirations/<topic>/`.

## 1. Capture

Screenshots are not required, except that a shared URL gets a screenshot request (see rules). Use the cheapest input that answers the question, and look at images only
when the question is visual (layout, density, above-the-fold order, visual hierarchy).

| Cost | Input | Good for |
| --- | --- | --- |
| Lowest | The user's own description of the pattern | They already know what they like |
| Low | Page text via fetch | Structure, block order, copy pattern, flow |
| Medium | Cropped screenshot of the relevant section | Layout, density, visual hierarchy |
| Highest | Full-page screenshot | Whole-page flow only; rarely needed |

Rules:

- If the user describes a pattern in words, work from the description. Do not fetch or open images to
  confirm it.
- For a folder of images, list the filenames first and open only those that match the brief. Ask before
  opening more than 5, and suggest cropping to the relevant section.
- For a URL the user shares, ask before anything else whether you may screenshot it to understand the
  layout (one short question, mobile and desktop viewport). If they agree, take the screenshots and work
  from them plus the page text. If they decline, work from text only and say the layout is not observed.
- Never describe a variant as following a reference's layout unless you have seen that layout.
- Browser work (screenshots, observing interaction) uses Chrome DevTools MCP only (`mcp__chrome-devtools__*`),
  never Playwright. If it is unavailable, ask the user for a screenshot instead.

| Input | How to read it |
| --- | --- |
| Local image or folder | Open the matching images only (see rules above). List the files you looked at. |
| Public URL | Ask to screenshot it (see rules above), then screenshot on yes and fetch the page text (web-fetch agent). |
| URL that fails, needs login, or blocks bots | Say so, and ask for a screenshot instead. Do not guess what the page shows. |
| Live interaction (motion, steps, hover) | Describe what you observed in the browser; if you could not observe it, mark it "not observed". |

Only study the part of the reference that matches the brief (e.g. the pricing block, not the whole site).

## 2. Break down each reference

For every reference, note:

- **Structure**: order of blocks, layout, what sits above the fold on mobile.
- **Hierarchy**: the primary action, what is emphasized, what is pushed down.
- **Interaction model**: scroll, tabs, steps, filters, selection, direct manipulation.
- **Trust and proof**: how it handles doubt (doctors, reviews, numbers, guarantees, FAQs).
- **Motion**: what moves, when, and why (or that nothing does).
- **Copy pattern**: headline style and tone, as a pattern only. Never reuse their words.
- **Weak spots**: what is confusing, slow, inaccessible, or wrong for our audience.

## 3. Pattern table

Write this before choosing directions (and save it as `prototypes/<slug>/references.md` in Build mode):

```
| Ref | Pattern | Why it works | Fit for us | Use in |
| --- | ------- | ------------ | ---------- | ------ |
| hims | Single-question entry card above the fold | Lowers the start cost | High: matches assessment KPI | Guided |
```

`Fit for us` checks the pattern against `docs/directions.md` (product sales first, assessments, trust for
prescription products) and our design system. Drop patterns that only work because of the reference's brand,
budget, or imagery.

## 4. Turn patterns into directions

- Spread the strongest patterns across directions so each one has a different backbone. Do not pile every
  good pattern into one variant.
- At least one direction should **push past** the references: combine two patterns, or solve a weak spot
  none of them solved. Mark its source as `ref + fresh`.
- If every reference solves the problem the same way, say so, and make one direction break that convention
  on purpose so the user can see the alternative.
- Rebuild every pattern with our `/design` components, tokens, and copy rules. If someone could mistake the
  variant for the reference site, it has gone too far.
