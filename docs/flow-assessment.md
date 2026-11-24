# Assessment Flow (Staff)

How doctors work through submitted assessments in the dashboard, from the patient's quiz to a care plan. It
covers the staff side before follow-ups. Patient-side states: `docs/patient-journey.md`. Follow-ups after the
order: `docs/patient-journey-simple.md`.

- Queue: `/dashboard/assessments` (`views/pages/dashboard/assessments.php`)
- Review page: `/dashboard/assessment?id=<assessment id>` (`views/pages/dashboard/assessment.php`)
- Components: `views/components/dashboard/assessment-row.php`, `assessment-decision.php`, `assessment-thread.php`
- Statuses, decisions and seed data: `includes/assessments-data.php`
- Session store, actions and queue groups: `includes/assessments-state.php`
- Quiz questions: `includes/assessment-quiz-data.php`
- Patient summary field: `assessment` in `includes/dashboard-patients-data.php`
- Workflow reference for doctors and product owners: `/dashboard/assessment-workflow`
  (`views/pages/dashboard/assessment-workflow.php`)
- When a status, rule or transition here changes, update this file in the same commit.

Status: ✅ built · ⚠️ partial · ❌ missing

---

## Flow

```mermaid
flowchart TD
  submit[Patient submits quiz] --> new[New]
  new -->|Doctor claims| in_review[In Review]
  in_review -->|Ask Patient| awaiting[Awaiting Patient]
  awaiting -->|Patient replies| in_review
  in_review -->|Record Care Plan| reviewed[Reviewed]
  in_review -->|Not Suitable| not_suitable[Not Suitable]
  reviewed --> order[Patient orders]
  order --> follow_ups[Follow-ups]
  not_suitable --> clinic[Book clinic / WhatsApp]
```

1. **Queue**: the doctor opens the Assessments list and claims an unclaimed case.
2. **Review**: quiz answers, photos, health flags, patient history (past orders, care products bought) and an
   internal note.
3. **Decision**: the doctor picks one action:
   - **Ask Patient**: sends a question. The case waits for the reply, then goes back to In Review.
   - **Record Care Plan**: Prescription, Basic Products Only or Consultation.
   - **Not Suitable**: the patient is referred to the clinic.
4. **Handover**: after a care plan the patient orders, and the order starts the follow-up chain
   (`/dashboard/follow-ups`).

---

## Statuses

| Status | Meaning | Owner | Next |
|---|---|---|---|
| New | Submitted, nobody has claimed it | Any doctor | Claim → In Review |
| In Review | Claimed; the doctor is reviewing | Claiming doctor | Ask Patient, Record Care Plan or Not Suitable |
| Awaiting Patient | The doctor asked a question | Patient | Reply → In Review (same doctor) |
| Reviewed | Care plan recorded | — | Patient orders → Follow-ups |
| Not Suitable | Not suitable for online care | — | Patient books a clinic visit or uses WhatsApp |

### Mapping to other surfaces

| Assessment status | Patient state (`/account`) | Patient list (`assessment` field) |
|---|---|---|
| — (no assessment) | `new` | Not Submitted |
| New, In Review | `pending` | Pending Review |
| Awaiting Patient | `needs_info` | Pending Review |
| Reviewed | `plan_ready` | Reviewed |
| Not Suitable | `not_suitable` (live only) | Reviewed |

### Live link with `/account`

The dashboard and `/account` share one session store (`includes/assessments-state.php`). The demo patient is
`account_patient` (PT-2001, Aisyah) in `includes/assessments-data.php`; her assessment is AS-3004 (New).

- `/account` (live, the default preview) shows her latest assessment above her orders, mapped as in the table
  above. `views/pages/account.php` builds `$account_live_assessment`; `views/pages/account/full.php` merges it
  over the sample.
- Awaiting Patient: `/account` shows the latest question. The reply posts to `/account` (`action=patient_reply`,
  `assets/js/account-reply.js`); the case returns to In Review with Patient Replied. Photos are counted only.
- Reviewed: the doctor’s message is the plan note. Prescription and Basic Products Only show sample products
  until prescription items are recorded; Consultation shows the note only.
- Not Suitable: “Your doctor’s advice” with the message and WhatsApp.
- Earlier rounds: answered questions show above the open question (Awaiting Patient), and under “Your messages
  with <doctor>” in the other states (`thread_history`, `account/doctor-thread` `history`).
- The session reseeds when the seed data changes, or with Reset Demo.

---

## Rules

| Rule | Value |
|---|---|
| Claiming | Self-claim. A doctor claims a New case from the queue; the case is then theirs |
| One owner | Only the claiming doctor can ask, record a plan or mark Not Suitable |
| Questions | No limit. Each Ask Patient → reply round is kept in the case thread |
| Patient reply | Returns the case to In Review with the same doctor |
| Decision | One final decision per assessment: Record Care Plan or Not Suitable |
| Care plan types | Prescription, Basic Products Only, Consultation. Decision types, not purchase statuses |
| Purchase | A care plan does not require a purchase. Buying a basic product never marks a prescription as fulfilled |
| Internal note | Staff only. Never shown to the patient |

---

## Screens

### Queue (`/dashboard/assessments`) ✅

- Collapsible groups, as on Follow-ups: Unclaimed (New), Mine (In Review, Awaiting Patient), Reviewed (Reviewed
  and Not Suitable, last 14 days, all doctors).
- Row: assessment and patient ID, name, photo count, reported changes, when first noticed, health flags, status,
  date (Submitted, Asked or Decided) and a hint (waiting time, question round, or decision and doctor).
- Order: Unclaimed oldest first. Mine: patient replies (Patient Replied badge), then In Review oldest first, then
  Awaiting Patient. Reviewed newest first.
- Actions: Claim (Unclaimed, posts and moves the case to Mine), Review (Mine), View (Reviewed).
- Demo: Mine belongs to the `signed_in` doctor in `includes/assessments-data.php`. Reset Demo (`?reset=1`)
  reseeds the session.

### Review page (`/dashboard/assessment?id=`) ✅

- Main column: Answers (health flags as badges, then every quiz answer), Photos (placeholders in the demo),
  Patient History (contact, last purchase, clinic visits, treatment).
- Check-ins: the patient’s self check-ins from `/account/treatment/checkin` (follow-ups session, `source = self`),
  newest first: product, order, date, outcome, refill and the answers. Read only.
- Sticky aside: Decision, Questions (thread), Internal Notes.
- Decision card by state:

| State | Decision card |
|---|---|
| New | Claim Assessment |
| Claimed by another doctor | Read only: who owns it |
| Awaiting Patient (mine) | Waiting for reply; Add Demo Reply (demo only) |
| In Review (mine) | Form: Action, Question for Patient, Care Plan, Message for Patient, Internal Note → Save Decision |
| Reviewed / Not Suitable | Outcome, care plan, date, doctor, message for patient |

Form validation (server-side, `includes/assessments-state.php`): an action is required. Ask Patient needs a
question. Record Care Plan needs a care plan type and a message. Not Suitable needs a message. Only the claiming
doctor can decide, and only while the case is In Review. The internal note is optional and kept on every action.

---

## Gaps

| Item | Status | Notes |
|---|---|---|
| Queue page with self-claim | ✅ | Session demo, no database |
| Review page with decision form | ✅ | Session demo |
| Patient replies from `/account` | ✅ | AS-3004 only; Add Demo Reply for the other patients |
| Real photos | ❌ | Placeholders by view (Top, Front, Crown) |
| Prescription items on Record Care Plan | ❌ | Only the care plan type is saved |
| Session demo state shared with `/account` | ✅ | Live preview only; other previews use sample data |
| Plan products from the doctor | ❌ | Sample products per care plan type |
| Staff sign-in | ❌ | Mine uses a fixed demo doctor (`signed_in`) |
| Patient list `assessment` field and `doctor` | ⚠️ | Separate seed in `includes/dashboard-patients-data.php`; not read from assessments |
| Multiple question rounds on `/account` | ✅ | Answered rounds show above the open question, then as “Your messages with <doctor>” |
| `not_suitable` patient state | ⚠️ | Live only; no `?state=` preview yet |
| Prescription flow | ❌ | Open question below |
| Overview counts linked to the queue | ⚠️ | `includes/dashboard-overview-data.php` shows sample counts; "View assessments" has no target |

---

## Open questions

- **Prescription**: issued on the review page, or on a separate Prescriptions page (sidebar link is also `#`)?
  Covers items, dosage, validity and refill approval.
- Can a doctor release a claimed case back to the queue, for example when unavailable?
- What happens when a patient never replies to a question: reminder, auto-close, or stays open?
- Not Suitable: fixed reasons list or free text? What does the patient see?

---

## Changelog

- 2026-11-25: Review page shows the patient’s self check-ins.
- 2026-11-24: `/account` shows earlier question rounds.
- 2026-11-24: Linked to `/account` (live): status mapping, patient replies, Not Suitable state.
- 2026-11-24: Review page built: answers, photos, history, decision form, question thread, internal notes.
- 2026-11-24: Queue page built: Unclaimed, Mine and Reviewed groups; self-claim.
- 2026-11-24: First version. Self-claim, unlimited question rounds and Not Suitable agreed; prescription open.
