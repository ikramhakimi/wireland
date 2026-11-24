# Changes — home

Prototype: `prototypes/convert-home/` (http://localhost/wireland/prototypes/convert-home/) · 2026-11-24
Variants: 1 Follow-through, 2 Start here · built from `04-brief.md` (provisional) · production untouched

## Both variants

| Element | Before | After | Why | Source |
| ------- | ------ | ----- | --- | ------ |
| Google review seal | "4.9", "500+" hard-coded in `google-review.php` | Removed | Rating and count have no source in the repo | Hard rule 2; `[PROOF NEEDED: real Google rating + link]` |
| Hero patient | "Raul Gonzalez, Age 45 · Hair thinning" | "[PROOF NEEDED: real patient]" | Looks like demo content; patient proof must be real and consented | 01 › Risks; SOURCES › Testimonials |
| Hero note | "New growth often shows within 4–8 months" | Removed | Outcome claim without a cited source | 01 › Risks; `copywriting.md` (no unsupported claims) |
| Hero note | "Prescription-strength ingredients" | Removed | Points at prescription medicine on a public page | `directions.md` §5 |
| Marquee | 10 facts | 7 facts: dropped "Doctor Review Within 24 Hours", "Prescription-Strength Treatments", "NPRA-Registered Medicines"; "Fast Delivery" → "Delivery"; added "Ongoing Care Team Support" | 24h and delivery speed unconfirmed; medicine items per §5; care team is the promise | F2, F5 [Confirm]; `directions.md` §4–5 |
| Video-call placeholder | Grey call mock (desktop) | Removed | Replaced by content that carries each variant's angle | 04 › Hero variants |

## Variant 1 — Follow-through

| Element | Before | After | Why | Source |
| ------- | ------ | ----- | --- | ------ |
| H1 | "Hair Transplant & Hair Loss Treatment in Malaysia" | "Start online, with a care team that stays for the months it takes." | Category words → the one promise competitors don't make | 02 › What none of them say; 04 › One promise |
| Sub | "Free Online Assessment · Doctor review within 24 hours" | "Hair treatment takes months, so your plan comes with check-ins, not just a first appointment." | Explains why follow-up matters | F6; `directions.md` §4 |
| Notes | 3 notes (above) | Free assessment reviewed by a doctor · Check-ins with your care team · No obligation to buy | Answers "is it free", "what after", "will I be pushed" | F1, F3, `directions.md` §4 [Confirm cadence] |
| Visual | Call mock + cycle | "How your care continues" timeline (4 steps, step 4 = check-ins) + cycle | Shows the promise; the cycle now reads as check-in photos | `directions.md` §2, §4 |

## Variant 2 — Start here

| Element | Before | After | Why | Source |
| ------- | ------ | ----- | --- | ------ |
| H1 | "Hair Transplant & Hair Loss Treatment in Malaysia" | "Find out what's behind your hair changes." | Leads with the buyer's question, not the category | 01 › Q2 "who is it for" not on the page |
| Sub | as above | "Start with a free online assessment. A doctor reviews your answers and recommends options, and you decide in your own time." | Low-commitment first step | F1, F3 |
| Notes | 3 notes | Free incl. doctor's review · No obligation · Everyday care without an assessment | Removes the two biggest hesitations; opens the shop path | F1, F3, F4 |
| Visual | Call mock + cycle | Two paths: "Not sure what you need?" (3-step assessment + Start Free Assessment) and "Know what you're looking for?" (everyday care + Shop Hair Care) | Both KPIs side by side, each with its own reason | `directions.md` §2 two purchase paths, §7 two actions |
| Actions | Two buttons in hero aside | Inside the path cards; Start Free Assessment also in the aside on phones | Keeps a CTA in the first screen at 390 | Compare check, 390px |

## Removed or placeholdered (no source)

- Google rating 4.9 / 500+ reviews.
- Hero patient name and progress photos.
- "4–8 months" growth claim; "within 24 hours" (until confirmed).

## Five questions, before → after

| # | Before | V1 Follow-through | V2 Start here |
| - | ------ | ----------------- | ------------- |
| 1 What is it? | Hair loss treatment (category) | Online start, ongoing care team | A way to find out what's behind hair changes |
| 2 Who for? | not on the page | People who know it takes months | People noticing changes, unsure what they need — or who already know |
| 3 What do I get? | Free assessment, 24h review | Doctor review, plan, check-ins | Doctor's recommendation, or everyday care now |
| 4 Why believe? | Marquee facts, demo photos | Process shown; proof is `[PROOF NEEDED]` | Free + no obligation; proof is thin |
| 5 Next? | Start Free Assessment | Start Free Assessment | Start Free Assessment / Shop Hair Care |

Both variants are weaker than they should be on #4 until real proof exists (MMC numbers, consented patient
photos, a real Google rating link).

## Compare check (2026-11-24)

- V1 at 1440: renders; no console errors.
- V2 at 390: first version had a 5-line H1 and no CTA in the first screen → H1 shortened, phone CTA added.
- Not checked: V1 at 390, V2 at 1440 (screenshot budget). Check by flipping the picker.

## Measure

- Primary: assessment starts from the hero (clicks on Start Free Assessment in the hero / sessions).
- Secondary: Shop Hair Care clicks from the hero; scroll past hero.
- A/B: current hero (`home-hero-4`) vs the chosen variant, 50/50, until each arm has ~300 assessment starts
  or 4 weeks, whichever is later.
