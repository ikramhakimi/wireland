# Brief — home

Built from 01, 02, 03 · 2026-11-24 · status: **draft, provisional** — user chose to proceed with 2 buyer quotes
(target 15–25). Lines marked `[VOICE NEEDED]` must be checked against real reviews before shipping.

- **Who (one moment):** someone who has noticed thinning for a while, has looked up clinics, and is unsure
  whether it is worth a clinic visit and a large bill to find out what is going on.
  Source: quiz options on the page ("1–12 months ago", "More than a year ago"); in-clinic spend tags of
  RM4,000 and RM15,000 (Q1, Q2). `[VOICE NEEDED]` — no complaint quotes yet confirm the hesitation.
- **Pain, their words:** `[VOICE NEEDED]` — no 1–2 star quotes collected (03-voice.md).
- **One promise:** "Start online with a doctor who follows your hair through the months it takes."
  Gap: neither C1 nor C2 claims follow-up after the first consult (02 › What none of them say).
  Facts: results take months (F6); "Follow-ups with the same doctor" (home doctors section);
  check-in cycle (`directions.md` §4). **[Confirm]** check-in cadence and same-doctor follow-up with client.

## Objection map

| Objection                              | Proof                                                        | Section            | Source |
| -------------------------------------- | ------------------------------------------------------------ | ------------------ | ------ |
| Is it really free?                     | Free assessment and doctor review                            | Hero               | F1 |
| Will I be pushed to buy?               | No obligation; read the recommendation in your own time      | Hero note, FAQ     | F3 |
| Are the doctors real?                  | Names, MMC numbers, qualifications                           | Doctors            | `[PROOF NEEDED: real MMC numbers]` |
| Is online enough, or do I need a clinic? | Doctor reviews answers, may ask follow-ups or book a video call | How it works     | `directions.md` §2 step 2 |
| How long until I see a change?         | Hair cycles; months; varies                                  | Hair cycle         | F6 |
| What about side effects?               | Doctor explains before prescribing; check-ins report side effects | FAQ (new item) | `directions.md` §4 alerts; C1 discloses prominently |
| What will it cost?                     | Everyday care priced; prescription price shown before deciding | Products, FAQ   | F4, FAQ |
| Is it private?                         | Answers seen only by your doctor; discreet packaging         | Marquee, FAQ       | F5, FAQ |

## Section order

| # | Section                      | Job                                                   | KPI         | Ends in                 | Reuses |
| - | ---------------------------- | ----------------------------------------------------- | ----------- | ----------------------- | ------ |
| 1 | Hero                         | The promise; who it is for; two actions               | Assessment  | Start Free Assessment / Shop Hair Care | `home-hero-4` structure |
| 2 | How it works                 | Four steps, with step 4 (check-ins) given equal weight | Assessment | Start Free Assessment   | `how-it-works-alt` |
| 3 | Our Products + Routine Sets  | Buy everyday care now, no assessment needed           | Discovery   | Add to Cart / Shop      | `home-shop-2` |
| 4 | How hair grows               | Why it takes months — and why follow-up matters       | Assessment  | Start Free Assessment   | `home-hair-cycle` |
| 5 | Our Doctors                  | Proof next to the action                              | Assessment  | Start Free Assessment   | `home-doctors` |
| 6 | Treatments (compact)         | Clinic options, secondary                             | —           | Learn more              | `home-treatments` |
| 7 | FAQ                          | Remaining objections, incl. side effects              | Both        | —                       | `home-faq-grouped` |

Change from today: section order stays; hero promise changes; side-effects FAQ item added; how-it-works
step 4 carries the promise. Rebuild scope for `build`: **hero only**.

## Hero variants to build (2–3, differ by angle)

1. **Follow-through** — lead with the promise (months, same doctor). Proof: check-in step visual.
2. **Start here, not at a clinic** — lead with the low-commitment entry: free online assessment, no
   obligation, everyday care from the shop. Proof: F1, F3, F4. No competitor prices named.
3. **Doctor first** — lead with the doctor and what they do over time. Proof: doctor card with real
   credentials. Blocked until MMC numbers are real.

## What stays

RR HairClinic logo, palette, type tokens, `/design` components, two hero actions ("Start Free Assessment",
"Shop Hair Care"), FAQ answers, product prices.

## Compliance flags

- Remove medicine names (Finasteride, Minoxidil) from hero and hair-cycle cards on the public page —
  `directions.md` §5. **[Confirm with client's regulatory advisor]**
- "New growth often shows within 4–8 months": needs a cited source or softer wording per
  `docs/copywriting.md` ("most treatments take several months").
- Hero patient "Raul Gonzalez", product reviews and before/after cycles: use only if real and consented;
  otherwise `[PROOF NEEDED]`.
- "MMC No. 00000": must be real before launch.

## Open questions

1. Is follow-up always with the same doctor, and what is the check-in cadence? (The promise depends on it.)
2. Is the 24-hour doctor reply confirmed?
3. Where does home traffic come from, and what does the ad say?
4. Are the reviews and before/after photos real?
