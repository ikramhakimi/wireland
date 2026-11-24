# Sources and compliance checks

## Where buyers talk (Malaysia, hair and telehealth)

Search in English and BM. Useful BM terms: `rambut gugur`, `rambut nipis`, `botak`, `minoxidil`,
`klinik rambut`, `rawatan rambut`, plus the competitor name with `review` / `ulasan` / `scam` / `mahal`.

| Source                    | Good for                                   | How to find it                                  |
| ------------------------- | ------------------------------------------ | ----------------------------------------------- |
| Google Maps reviews       | Clinic competitors (1–2 star complaints)   | `<clinic name> reviews`, Maps listing           |
| Reddit                    | Honest comparisons, price talk, side effects | r/malaysia, r/MalaysianPF, r/tressless (global) |
| Lowyat forum              | Long threads on clinics, minoxidil, prices | `site:forum.lowyat.net <topic>`                 |
| Shopee / Lazada reviews   | Shampoo, serum, supplement buyers          | Product page reviews, filter 1–2 stars          |
| App Store / Google Play   | Telehealth app competitors                 | App listing, sort by most critical              |
| Trustpilot                | Global telehealth (Hims, Manual, Numan)    | `trustpilot.com/review/<domain>`                |
| Facebook / Instagram comments | Ads and posts from competitors         | Only if publicly reachable via fetch            |

If a source cannot be fetched (login wall, blocked), skip it and say so in the file. Never quote from memory.

### Known fetch limits (tested 2026-11-24)

Plain web fetch is refused by reddit.com and hims.com, and cannot open Google Maps reviews or Lowyat search.
Directory sites (WhatClinic) and competitor homepages work. So:

1. Fetch what works first (competitor pages, WhatClinic, Shopee/Lazada product pages).
2. For blocked sources, use the browser MCP (chrome-devtools or playwright) and read with a text snapshot,
   not screenshots. Ask the user first: it opens their browser.
3. Otherwise ask the user to paste reviews or exact thread URLs into `docs/convert/<page>/raw-reviews.md`,
   with the link above each one. Treat pasted reviews like fetched ones: verbatim, linked, no names.
4. Under 10 quotes: write `03-voice.md` with what exists, mark it insufficient, and stop before the brief.

## Compliance flags (Malaysia)

Flag these in the brief and change log for the user and client to confirm. Do not present them as legal advice.

| Flag              | Check                                                                                     |
| ----------------- | ----------------------------------------------------------------------------------------- |
| Prescription meds | Does the copy name, price or picture a prescription medicine on a public page? (see `docs/directions.md` §5) |
| Outcome claims    | "Regrow", "stop hair loss", "proven", "%" results, timeframes without a cited source.     |
| Testimonials      | Patient testimonials and before/after photos for medical services are restricted; flag any use. |
| Doctor claims     | Doctor names, credentials, MMC registration must be real and confirmed.                   |
| Pricing / free    | "Free assessment", fees, refunds must match the confirmed model (`[Confirm]` items).      |
| Health data       | Any copy about privacy or data must match the actual PDPA notice.                         |
| Urgency           | No fake scarcity or countdowns (also against `docs/copywriting.md`).                      |
