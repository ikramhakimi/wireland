---
name: convert
description: Rebuild a public page so it converts, by giving Claude the context it lacks — the page read as a buyer, the competitors buyers compare it with, and the exact words buyers use in reviews — then a brief, then a sourced rebuild in a prototype. Use when the user asks to make a page convert, improve a landing/home page's conversion, rewrite a hero for buyers, research competitors' messaging, or names /convert. Modes: audit, research, brief, build, compare.
---

# Convert

A page that "looks fine" but does not sell usually has a context problem, not a design problem: it says what
every page in the category says. This skill gathers the missing context first, writes it down, and only then
rebuilds — and every change on the new page points back to a source.

## Hard rules

1. **No build before an approved brief.** Phases 1–4 are research and writing only. Stop after the brief and
   wait for the user. Never edit production files in this skill; rebuilds go to `prototypes/convert-<page>/`.
2. **Nothing invented.** No made-up testimonials, review counts, ratings, doctor names, prices, timings,
   statistics or logos. Missing proof becomes a visible placeholder: `[PROOF NEEDED: what would prove this]`.
3. **Quotes are verbatim, with a link.** Never paraphrase, translate, tidy or merge a buyer quote. Keep BM,
   Manglish and typos as written. A quote without a URL is not used.
4. **Medical claims are flagged, not decided.** Follow the compliance checks in [SOURCES.md](SOURCES.md).
   The skill flags risk for the user and client; it does not give legal clearance.
5. **Project rules still apply.** `AGENTS.md`, `docs/copywriting.md`, `docs/directions.md` and the `/design`
   components win over anything a competitor or reviewer does. Buyer voice informs the brief; final copy
   follows the brand voice.
6. **Write to files, not chat.** Each phase writes its file in `docs/convert/<page>/`, so work can resume and
   the user can edit between phases. Chat gets a short summary and the file link.
7. **Token budget.** Read own pages with `php prototypes/_kit/page-text.php <url>` and the source templates.
   Read competitors as text (web fetch). Screenshots: at most 3 per run, only where layout matters.

## Modes

Run one mode per invocation unless the user asks for more. With no mode, check which files exist in
`docs/convert/<page>/` and run the next missing phase.

| Mode       | Phase | Writes              | Needs                     |
| ---------- | ----- | ------------------- | ------------------------- |
| `audit`    | 0–1   | `01-audit.md`       | page URL                  |
| `research` | 2–3   | `02-competitors.md`, `03-voice.md` | `01-audit.md` |
| `brief`    | 4     | `04-brief.md`       | files 01–03               |
| `build`    | 5     | `prototypes/convert-<page>/`, `05-changes.md` | approved `04-brief.md` |
| `compare`  | 6     | appends to `05-changes.md` | built prototype    |

`<page>` is a short slug: `home`, `assessment`, `product`.

Templates for every file are in [TEMPLATES.md](TEMPLATES.md). Use them; keep each file scannable.

## Phase 0 — Goal (part of `audit`)

Before reading the page, write down from `docs/directions.md` and the user:

- the page's job: which KPI it serves (product discovery, assessment starts) and its primary action;
- where traffic comes from, if known (ads, organic, Instagram, WhatsApp). If an ad or post feeds this page,
  note its promise: the hero must match it (message match);
- what must stay: logo, palette, components, real numbers, confirmed facts.

Unknowns are listed as questions, not guessed.

## Phase 1 — Read the page like a buyer (`audit`)

1. `php prototypes/_kit/page-text.php <url> 8000` for the copy in order; read the page template and its
   sections for structure. page-text strips `<header>`, so always take the hero `<h1>` and sub from the hero
   section source. Read mobile first: most visitors are on a phone (~390px).
2. List the copy in order: headline, sub, each section's headline, buttons, proof.
3. Answer the five buyer questions in one line each, **quoting the page**:
   what is it? who is it for? what do I get? why should I believe it? what do I do next?
   If the page does not say it, write `not on the page`. Those are the first things to fix.
4. Note where the answer is technically there but in category words ("hair loss treatment online") that any
   competitor could use. That is where the work is.
5. List objections a buyer would have before acting, and whether the page answers each (and where).

## Phase 2 — Study the competitors (`research`)

Find them yourself unless the user gives a list. Search the way a buyer would: in English and BM, Malaysia
first, then 1–2 global references from `docs/directions.md` (e.g. Hims) for pattern contrast only.
Pick 3–5 that a buyer of this page would realistically have open in another tab; say why each was chosen.

For each, from its homepage/landing (text via fetch; one screenshot only if the hero layout matters):
headline, sub, primary button and where it leads, proof shown and where, price/fee disclosure, what the
hero shows (people, product, doctor, app), and the risk-reducers (free, no commitment, refund, privacy).

End with two lists: **what they all say** (table stakes — do not lead with these) and **what none of them
say** (candidate promise). The second list is usually where the headline comes from.

## Phase 3 — Steal the words from reviews (`research`)

Collect 15–25 quotes, word for word, each with its URL: mostly 1–2 star reviews of competitors (the problems
the page should answer), plus a few 4–5 star ones (what buyers value), plus the client's own if public.
Where to look is in [SOURCES.md](SOURCES.md). Group quotes by the pain they describe; count per group.

Rules: never rewrite or invent a quote; skip a quote if you cannot open its source; strip personal names
other than the platform's public display name; do not quote health details that identify a person.

If fewer than 10 usable quotes exist, say so — do not pad. If the user still asks to proceed, mark the brief
`provisional` and write `[VOICE NEEDED]` wherever a line would have cited a quote.

## Phase 4 — Write the brief (`brief`)

One page, from files 01–03. Every line cites its source file and item. It contains:

- **Who**, in one moment ("noticing more hair on the pillow and unsure if it's normal"), not a demographic.
- **Their pain, in their words**: 2–3 quotes from `03-voice.md`.
- **One promise**, in one line. If it cannot be written in one line, stop and ask the user.
- **Objection map**: objection → proof that answers it → section where it is answered. Proof that does not
  exist yet is `[PROOF NEEDED]`.
- **Section order** for the rebuilt page, each section pushing one KPI and ending in a path.
- **What stays**: brand, components, confirmed numbers, legal copy.
- **Compliance flags** from [SOURCES.md](SOURCES.md).
- **Open questions** for the client (from `[Confirm]` items in `docs/directions.md` that block the promise).

Then stop: show the promise, the section order and the open questions, and ask for approval or edits.

## Phase 5 — Rebuild, hero first (`build`)

Only with an approved brief. Build in `prototypes/convert-<page>/` using `prototypes/_kit/harness.php`, the
same way as existing prototypes (see `prototypes/home-hero-quiz-2/index.php`):

- Start with the hero only. Rest of the page comes in a later run, after the hero is chosen.
- 2–3 variants that differ in **promise or proof**, not just styling (e.g. "lead with the pain quote",
  "lead with the missing promise", "lead with the doctor step"). Name each by its angle.
- Reuse existing sections and components (`views/sections/home-hero-*.php`, `component(...)`); no new
  production CSS. Prototype CSS needs a change notice per `AGENTS.md`.
- Copy follows `docs/copywriting.md`: Title Case buttons, CTA labels match the destination, no guarantees.

Write `05-changes.md`: every changed headline, claim, proof or CTA → why → source (quote ID, competitor gap,
or confirmed fact). Anything with no source comes off the page or becomes `[PROOF NEEDED]`.

## Phase 6 — Compare and source every claim (`compare`)

Old vs new, at 390 and 1440 (one screenshot each at most; otherwise page-text). Re-answer the five buyer
questions for the new version. Run the copy review checklist in `docs/copywriting.md` and the compliance
checks. Add to `05-changes.md`:

- the before/after answers to the five questions;
- unsourced claims removed;
- what to measure (assessment starts, add-to-cart from hero, scroll past hero) and a suggested A/B split
  (current hero vs chosen variant).

Integration into production is a separate request that follows `AGENTS.md`; this skill ends here.

## Common mistakes

1. Starting with the design. A prettier version of the wrong promise still does not sell.
2. Three promises in the headline. Pick one; the others go lower.
3. Paraphrasing reviews. "Users find it expensive" is dead; the buyer's own sentence is not.
4. Copying a competitor. Study them to find the gap, not the template.
5. Letting Claude invent proof. A fake testimonial costs more trust than none — and in health it may be
   illegal.
6. Rebuilding everything at once. Hero first.
