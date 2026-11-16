# Dashboard Copywriting

## Scope and Audience

Use this guide for dashboard copy intended for doctors, operations staff and administrators.
Use `docs/copywriting.md` for the public website and patient-facing content.
For dashboard wording, this guide takes priority where the two guides differ.
Apply changes only within the requested scope.

## Voice

Write in clear English. Be calm, helpful and concise.
Help staff understand the information, make a decision and complete their task.

- Say what matters in as few words as clarity allows.
- Use familiar verbs and concrete nouns.
- Keep established work terms, such as SKU, dispatch and follow-up.
- Explain a work term only when its meaning or consequence could be unclear.
- Describe actual behaviour. Do not promise an outcome the system cannot confirm.
- For errors, explain the problem and give a specific next action.

## Default: Labels First

A clear label is usually enough. Add helper text only when it explains a decision,
constraint or consequence that the label cannot communicate.

- Do not repeat the label in a description or helper.
- Omit card and page descriptions when the heading already explains the purpose.
- Put guidance beside the decision it supports; do not repeat it across the page.
- Keep necessary limits, timing rules and pricing behaviour visible.
- Prefer one short sentence. Add another only when it provides needed information.
- Keep internal implementation details out of task instructions.

| Context | Avoid | Prefer |
| --- | --- | --- |
| Clear field | Price — “Enter the price for this product.” | Price |
| Clear card | Basic Information — “Identify the product and organise it in the catalogue.” | Basic Information |
| Unclear timing | “Choose a timeframe confirmed by the clinic. Dispatch time is the time to send, not arrival.” | “Time to dispatch, not delivery.” |
| Price calculation | “Choose a percentage to calculate from the regular or combo price, rounded down to the whole Ringgit.” | “Percentage discounts round down to whole RM.” |
| Input format | “Please enter each approved benefit on a separate line below.” | “One approved benefit per line.” |

These are wording examples. Use them only when they match the actual behaviour and requirements.

## Labels and Actions

Use Title Case for field labels, buttons and links styled as buttons.
Use sentence case for descriptions, placeholders, helper text, validation and status messages.
Preserve acronyms and names such as SKU, RM and SMS. Do not apply automatic capitalization.

- Name fields by the information they contain: “Product Name”, “Dispatch Time”.
- Name actions by what they do: “Create Product”, “Save Changes”, “Add FAQ”.
- Use distinct names for distinct concepts: Combined Price, Combo Price and Discount Price.
- Use placeholders for examples or expected formats, never as a replacement for labels.
- Do not invent required information or rules to make the copy sound complete.

## Errors: Problem + Action

State what went wrong, then tell the user how to resolve it. Keep both parts specific.
Avoid blame, vague failure messages and unnecessary apologies.

| Situation | Copy |
| --- | --- |
| Missing name | “Product name is missing. Enter a name.” |
| Duplicate SKU | “This SKU is already in use. Enter a different SKU.” |
| Invalid quantity | “Quantity must be a whole number. Enter 1 or more.” |
| Invalid discount | “Discount price must be lower. Enter a price below the regular or combo price.” |
| Incomplete FAQ | “The answer is missing. Add an answer or remove this FAQ.” |

Only suggest recovery actions that are supported by the system. If the cause of a failure is
unknown, say what could not be completed and offer an available next step without inventing a cause.

## Status, Empty States and Confirmations

- Status: state the result briefly, for example “Changes saved.” or “Image removed.”
- Empty state: state what is missing and the next useful action, for example
  “No products found. Try another name or SKU.”
- Confirmation: describe the action and its actual consequence. Use a specific action button.
- Explain irreversible consequences when relevant; do not add routine confirmation prompts.
- Use the same terms in controls, messages and related pages.

## Clinical and Operational Accuracy

Keep claims, requirements and instructions grounded in confirmed clinic information.
Do not infer that a product needs no consultation, has a particular benefit or will arrive within
a certain timeframe. Preserve distinctions between consultation and prescription requirements,
dispatch and delivery, and combo pricing and additional discounts.

## Review Checklist

- Is a label enough, or does this helper support a real decision?
- Does each sentence add information?
- Is the wording calm, helpful and direct?
- Are work terms consistent and explained only where needed?
- Does an error identify both the problem and a useful action?
- Are important limits and consequences still clear?
- Does the copy match confirmed system behaviour and clinic information?

## Open Preferences

No additional banned words or reference phrases have been specified.
Do not treat unstated stylistic preferences as user requirements.
