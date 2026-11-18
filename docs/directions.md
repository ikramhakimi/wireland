# RR — Project Directions

Working reference for the RR online shop + telehealth build. It records what the client asked for, how
we interpret it, open questions, and the creative directions for the home page variations.

Status: draft after discovery (2026-11). Items marked **[Confirm]** need client sign-off.

---

## 1. Goals

1. **Grow direct sales.** Move product sales from Yezza to RR's own shop.
2. **Make prescription products purchasable online.** Some products need a prescription, so a doctor-led
   telehealth flow (assessment → review → prescription) sits in front of checkout for those items.
3. **Keep clients on a plan.** A client dashboard and follow-ups (email, SMS/WhatsApp, video) drive
   adherence, results, and repeat purchase.

### Priority

**Product sales come first.** Clinic services (in-clinic treatments) stay on the site but are secondary:
a supporting section or link, never the hero or the primary CTA.

### Key KPIs

1. **Product discovery**: visitors who browse product/concern pages, product detail views, add-to-cart.
2. **Assessments**: assessment starts, completion rate, assessment → purchase conversion.

Secondary signals: share of orders on own shop vs Yezza, refill/repeat rate at 3 and 6 months,
clinic enquiries.

Every home page section should push one of the two KPIs: *explore products* or *start the assessment*.

---

## 2. Client journey

| # | Step                  | Owner  | What happens                                                     | Surfaces                  |
|---|-----------------------|--------|------------------------------------------------------------------|---------------------------|
| 1 | Assessment (quiz)     | Client | Shares hair concerns, history, and relevant health information.  | `assessment`              |
| 2 | Doctor evaluation     | Doctor | Reviews answers; may ask follow-up questions or book a video call. | Doctor tool (TBD)       |
| 3 | Prescription / plan   | Doctor | Recommends products or treatment; prescribes where appropriate.  | Dashboard → Prescription  |
| 4 | Purchase              | Client | Buys the recommended plan.                                       | `product`, `cart`, `checkout` |
| 5 | Monitoring            | Doctor | Check-ins on usage, effects, side effects; adjusts plan.         | Email, SMS/WhatsApp, video |
| 6 | Repeat purchase       | Client | Refills, subject to prescription validity and any required review. | Dashboard → Upcoming actions |

### Two purchase paths

The shop should not force every visitor through the quiz.

- **Non-prescription products** (shampoo, serum, supplements): buy directly, like any shop.
  The quiz is offered, not required.
- **Prescription products**: assessment + doctor approval before they can be bought.

**[Confirm]** Which SKUs are prescription-only, and which are open purchase.

### Pay before or after the doctor?

Discovery lists *Prescription → Purchase*. Hims-style flows usually take payment (or a hold) at the end
of the quiz and refund if the doctor declines. Options:

- **A. Review first, pay after** (as briefed). Lower friction to start, but clients drop off while
  waiting for the doctor.
- **B. Pay/hold at end of quiz, refund if not suitable.** Higher conversion and commitment; needs a clear
  refund message.

**[Confirm]** Preferred model, consultation fee (free / paid / credited to first order), and target
doctor turnaround time (this is the key promise on the home page).

---

## 3. Client dashboard

| Area              | Contents                                                              |
|-------------------|-----------------------------------------------------------------------|
| Purchase history  | Orders, status, invoices, reorder.                                    |
| Prescription      | Active prescriptions, prescribing doctor, issue/expiry date, status.  |
| Product plan      | What to use, how, and when; current plan vs previous.                 |
| Upcoming actions  | Follow-up check-ins, reviews due, refills due, video appointments.    |

Suggested additions (propose, not committed): progress photos timeline, message the care team, plan
change requests. Dashboard copy follows `docs/copywriting-dashboard.md`.

---

## 4. Follow-up and monitoring

| Channel          | Use for                                                            |
|------------------|--------------------------------------------------------------------|
| Email            | Plan summary, receipts, scheduled check-ins, refill reminders.      |
| SMS / WhatsApp   | Short nudges: check-in due, refill due, doctor replied.             |
| Video            | Only when the doctor needs it (side effects, unclear progress).     |

**[Confirm]** Check-in cadence (e.g. week 2, month 1, month 3), prescription validity period, and
whether refills auto-renew or require a review.

### Follow-up cycle (proposed)

Hair treatment takes 3–6 months to show results, so follow-up is a repeating cycle, not a final step.
Each check-in is a small review that reuses the first review's pattern (review → question → decision).

```
Assessment → Doctor review → Plan → Treatment ──→ Check-in (e.g. week 4, 12, 24)
                  ↑                                     │
                  └──────── adjust plan / refill ←──────┘
```

**Patient states** (account overview, after the first plan):

| State           | Patient sees                                          | Main action                         |
|-----------------|-------------------------------------------------------|-------------------------------------|
| Ordered         | Order status and delivery date.                       | Track order                         |
| On treatment    | Day of supply (e.g. "Day 18 of 30"), next check-in.   | None                                |
| Check-in due    | Which check-in is due and how long it takes.          | Start check-in (photos + short questions) |
| Check-in review | Same as the first pending review.                     | None (doctor may ask a question)    |
| Refill due      | Days of supply left; whether a review is needed first. | Order refill                       |

Once treatment starts, the account tracker switches from the first-plan steps to a treatment timeline
(check-in points), so the patient sees long-term progress, not a finished process.

**Doctor side** (doctor tool / dashboard):

- **Check-in queue:** submitted check-ins, sorted by priority (flags such as side effects or no change).
- **Side-by-side comparison:** baseline vs check-in photos and answers.
- **Quick decisions:** Continue / Adjust plan / Ask a question / Book a video call; each sets the
  patient's next state.
- **Alerts:** missed check-ins, refills not ordered, reported side effects.

Account overview: `/account?state=on_treatment` and `?state=checkin_due` (status tracker). Workflow detail:
`/dashboard/assessment-workflow` (section 07).

**[Confirm]** What a check-in contains (photos, questions), and whether a check-in is required before a
refill.

---

## 5. Open questions and risks

- **Medicine advertising (Malaysia).** Prescription medicines generally cannot be advertised to the
  public. Public pages may need to talk about concerns, the assessment, and doctor-led care rather than
  naming or pricing prescription products. Prescription items may only be visible after doctor approval.
  **[Confirm with client / their regulatory advisor]** before we design product listings.
- **Telemedicine rules.** Confirm MMC requirements for remote prescribing (e.g. when a video consult is
  mandatory, doctor registration display, record keeping).
- **Health data (PDPA).** The quiz collects health information. Needs consent wording, privacy notice,
  and secure storage; affects the quiz and dashboard UX.
- **Yezza.** Does Yezza stay live in parallel? Price parity? Migrating existing customers?
- **In-clinic services.** Decided: kept, but secondary to product sales (one compact section near the
  end of the home page). **[Confirm]** which clinic services to list.
- **Doctor tooling.** The doctor review/prescription interface is not in the current scope list.
- **Fulfilment.** Who dispenses prescription products (in-house pharmacy vs partner), and delivery times.

---

## 6. Design direction

References: Hims.com, Apple product pages, casual lifestyle. Not a pharmacy or clinic look.

### Principles

- **Lifestyle first, medicine underneath.** Lead with people and everyday moments; bring in doctor
  credibility as reassurance, not as the headline.
- **Product as hero (Apple).** Large, clean product shots, generous whitespace, one idea per section,
  short headlines.
- **Simple path to start (Hims).** One primary action everywhere: start the assessment. Show the
  journey in 3–4 steps.
- **Warm, not clinical.** Avoid white-coat imagery, stock clinic photos, blue-and-white sterile
  palettes, and dense medical text.
- **Honest.** No guaranteed results, no fake urgency. Follow `docs/copywriting.md`.

### Do / avoid

| Do                                              | Avoid                                         |
|-------------------------------------------------|-----------------------------------------------|
| Real-life photography, natural light            | Clinic corridors, lab coats as hero image     |
| Product close-ups on simple backgrounds         | Pill bottle grids like a pharmacy catalogue   |
| Short headlines, plain language                 | Medical jargon in headlines                   |
| Doctor faces + credentials near the CTA         | Doctor-first hero that feels like a hospital  |
| Clear "how it works" and pricing expectations   | Hidden steps or surprise consultation fees    |

---

## 7. Home page variations

### Shared rules

- **Two actions, everywhere:** *Shop products* (discovery) and *Start assessment*. Each variation picks
  which one is primary; the other is always visible as secondary.
- **Above the fold** shows products or a concern entry point, not doctors or clinic.
- **Every section ends in a path** to a product, a concern, or the assessment. No dead-end sections.
- **Clinic services:** one compact section near the end (e.g. "Prefer in-clinic care?"), not in the hero.
- Each variation still answers: *What is this? Is it for me? What happens next?*

### Comparison

| Variation             | Primary KPI        | Primary CTA       | Best for                                   |
|-----------------------|--------------------|-------------------|--------------------------------------------|
| A. Shop by concern    | Discovery + quiz   | Shop by concern   | Visitors who know their problem            |
| B. Product showcase   | Discovery          | Shop products     | Visitors browsing, comparing products      |
| C. Assessment-first   | Assessments        | Start assessment  | Visitors unsure what they need             |
| D. Find your routine  | Discovery + quiz   | Build my routine  | Repeat purchase, kits, higher order value  |

### Variation A — "Shop by concern" (Hims-led, recommended start)

Lifestyle brand feel; concerns are the doorway to products and the quiz.

1. **Hero:** lifestyle photo, short headline, concern chips (thinning, receding, shedding, scalp, hair
   care). Secondary CTA: start assessment.
2. **Concern rows:** each concern shows 2–3 matching products + "Not sure? Take the assessment".
3. **Best sellers:** clean product row, open-purchase items with price and add-to-cart.
4. **Doctor-prescribed options:** described by outcome, unlocked through the assessment (see section 5).
5. **How it works:** assessment → doctor review → delivered → check-ins.
6. **Results / testimonials**, then **doctors** (compact).
7. **Clinic services** (compact), **FAQ**, final CTA.

### Variation B — "Product showcase" (Apple-led)

Minimal, product as hero, one idea per screen. Strongest for discovery.

1. **Hero:** hero product or kit on a plain background, one-line headline, Shop + Assessment CTAs.
2. **Product lineup:** horizontal lineup (Apple "explore the lineup" style) with category tabs.
3. **Feature blocks:** full-width, one per product benefit, each linking to its product page.
4. **Compare kits:** Starter / Complete / Prescription plan side by side.
5. **"Not sure which one?"** band → assessment.
6. **Doctors, clinic services** (compact), **FAQ**.

### Variation C — "Assessment-first"

The hero is the first quiz question, so the visitor starts without an extra click. Strongest for
assessment starts.

1. **Hero:** "What's your main hair concern?" with 4–5 answer cards → continues in `assessment`.
   Under it: "Or shop all products".
2. **What you get:** doctor review, personalised plan, delivery, check-ins (with timing once confirmed).
3. **Popular plans and products:** what people are often recommended, linked to product pages.
4. **How it works**, **results**, **doctors**.
5. **Clinic services** (compact), **FAQ**, final CTA.

### Variation D — "Find your routine"

Sells a routine (several products together), not one item. Strongest for order value and refills.

1. **Hero:** "Build your hair routine" with a short 3-step picker (concern → hair type → goal) →
   recommended routine of open-purchase products. Secondary: full assessment for prescription options.
2. **Routine bundles:** ready-made routines with price and add-to-cart.
3. **Your plan, ongoing:** dashboard preview (plan, refill reminder, check-in).
4. **Upgrade with a doctor:** assessment for prescription options.
5. **Results, doctors, clinic services** (compact), **FAQ**.

### Mapping to existing sections

Reuse where possible before building new ones:

- Hero: `home-life-hero-alt`, `home-life-hero-1/2/3`
- Concerns: `home-problems`, `home-problems-2`
- Products: `home-life-products-option-*`
- How it works: `how-it-works-alt`, `how-it-works-journey`
- Proof: `home-life-results`, `home-life-testimonial`, `home-life-team`
- Clinic services: `home-services`, `home-services-2` (compact variant)
- Close: `home-faq`, `home-life-startup`, `footer`

New sections likely needed:

| Section                    | Used in | Notes                                              |
|----------------------------|---------|----------------------------------------------------|
| Concern chips hero         | A       | Could extend an existing hero with chip links      |
| Concern → product rows     | A       | Built from existing product card component         |
| Product lineup with tabs   | B       | Needs small JS for tabs                            |
| Kit comparison             | B       | Table/cards                                        |
| Quiz-first hero            | C       | Answer cards link into `assessment` with a param   |
| Routine picker + bundles   | D       | Needs JS; bundles could reuse product cards        |
| Dashboard preview          | D       | Static mock of the dashboard                       |
| Compact clinic services    | All     | Smaller variant of `home-services-2`               |
