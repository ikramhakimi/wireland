# Lifestyle hero exploration

Open `http://localhost/wireland/prototype-hero.php`.

- **Lifestyle:** portrait-led split with a product inset. Strongest at emotional connection; depends on photography.
- **Discovery:** centered introduction and interactive product categories. Strongest at discovery; less immediate emotion.
- **Proof:** bold promise, product/portrait mosaic and ingredient research. Strongest at addressing uncertainty; denser.

Use `1`–`3` or arrow keys to switch. `?v=2` opens a specific direction. No production page imports this folder.

Product switches update the image and description. Assessment and product CTAs open an accessible native dialog.
The two-question assessment is an isolated interaction preview: no diagnosis, network submission or persistent answers.
There is no assessment backend configured in the existing site.

The existing navbar, compiled Tailwind stylesheet, Poppins and SVG helper are reused.
Typography uses Tailwind utilities, including responsive sizes and zinc text colors. All interface accents use zinc.
Art-direction CSS loads directly from this folder. The prototype folder is registered as a Tailwind source.
Run `npm run watch:css` to generate the new utilities before previewing; no compile was run in this session.

## Assets and evidence

- Product imagery: existing unbranded mockups in `assets/images`; not final product packaging.
- Stock portrait: https://images.unsplash.com/photo-1506794778202-cad84cf45f1d
  ([Unsplash license](https://unsplash.com/license)). Not a patient or a treatment result.
- Finasteride study: https://pubmed.ncbi.nlm.nih.gov/9777765/
- Minoxidil study: https://pubmed.ncbi.nlm.nih.gov/12196747/

The research panel describes study design rather than asserting RR HairClinic product outcomes.
No ratings, customer results, testimonials, product prices or treatment timelines are invented.

## Preview gap

The three desktop directions were visually reviewed in native Chrome during the polish pass.
Mobile rendering, full keyboard interaction and browser console checks remain outstanding.
No build, compile or lint was run.
