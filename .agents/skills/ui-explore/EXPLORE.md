# Explore: interview and range

Load this from [SKILL.md](SKILL.md) Phase 3 when the brief includes `ask` or `ask+`, or the range is
`mixed` or `bold` (the default is `mixed`). A `safe` brief without `ask` does not need it.

## Interview: `ask`

**`ask` (on request only).** When the brief includes `ask`, after Phase 2 recon and before
Phase 3, ask these 4 questions in one `AskUserQuestion` call. Build 2–3 options per question from the recon,
put the inferred answer first marked "(Recommended)", and keep "Other" for free text:

| # | Header | Question | Why it changes the directions |
| - | ------ | -------- | ----------------------------- |
| 1 | User | Who is this for, and at what moment? (e.g. new visitor comparing, returning patient mid-treatment) | Sets the doubts and copy every direction answers |
| 2 | Action | What is the one thing they should do here? | Decides the primary action and what "success" means in the design check |
| 3 | Barrier | What stops them from doing it today? (e.g. unsure it works, cost, unclear next step) | Turns directions into different ways of removing the barrier, not different layouts |
| 4 | Range | How far should the directions go? (safe · mixed · bold, see Range) | Sets how wide the axes spread and whether bold rules apply |

## Interview: `ask+`

**`ask+`** asks the 4 above, then a second call with 3 more, for client work or large briefs:

| # | Header | Question | Why it changes the directions |
| - | ------ | -------- | ----------------------------- |
| 5 | Feel | When they finish, how should they feel? (calm · in control · motivated · cared for) | Drives the Personality and Trust axes, copy tone, density, motion |
| 6 | Fixed | What must not change? (e.g. price visible, prescription rules, a given component) | Prevents directions that break a business rule |
| 7 | Avoid | What should it not look or feel like? | Narrows the space faster than positive references |

Skip a question whose answer is already explicit in the brief, and say which you skipped. Never ask what
evidence exists (photos, reviews, doctor data): list it as an assumption and flag variants that depend on
it. The answers replace the matching assumptions; anything not asked still appears in `Assumptions`.

## Range

Range is set by the `ask` answer, by the brief (`safe`, `mixed`, `bold`), or inferred (default `mixed`).

| Range | Directions |
| --- | --- |
| **safe** | All within today's layout and interaction model; they differ on hierarchy, density, content |
| **mixed** | Safe directions plus exactly one bold direction |
| **bold** | Every direction is bold, and one of them is a provocation |

A **bold** direction must pass all of these; if it fails one, replace it:

1. **Structural change.** It changes at least 2 of: the interaction model, the unit (e.g. card → conversation,
   one question, timeline), what is primary, the content strategy. Visual styling alone never counts.
2. **Named break.** Before choosing directions, list the 3–5 conventions today's page and the references
   share (e.g. "one card per product", "actions at the bottom", "status as a pill"). Each bold direction
   states `Breaks: <convention>`.
3. **Distance test.** "With logo and copy removed, could this pass for today's page restyled?" If yes, it is
   not bold.
4. **Overgenerate, then cull.** For `bold`, first write 8 one-line concepts, drop the most conventional half,
   and choose from the rest. List the dropped ones in one line so the user can revive any.
5. **Provocation.** In `bold`, one direction breaks a basic premise (e.g. "no buttons, everything happens in
   WhatsApp", "the page is one question"). It need not ship; label it `Provocation`.
6. **Looser composition.** Tokens, typography, and colors stay. New compositions of existing components are
   allowed inside the prototype, flagged `New pattern`, instead of being blocked by Hard Rule 3.
7. **Judged on the job, not the form.** The design check asks whether the user can clearly complete the job;
   the primary action may not be a button and may not sit above the fold if the direction explains why.
