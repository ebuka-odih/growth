# GrowSphere Solutions

Public website + admin panel for **GrowSphere Solutions Limited** — a branding, marketing, technology and
creative media company, and the **GrowSphere Community**, its cohort-based training arm.

Laravel 12 · Blade · Tailwind CSS 4 (Vite) · SQLite.
Served by Herd at **http://growth.test**.

---

## Brand

Taken from `assets/GrowSphere Brand Document.pdf` — not from `resources/design/grow.reference.html`,
which was an early mock using a different (unofficial) violet/amber palette.

| Token | Value | Use |
| --- | --- | --- |
| `--color-deep` | `#330066` | Primary. Buttons, headings, dark surfaces. |
| `--color-deep-900` | `#1A0033` | Deepest surfaces, footer, dark sections. |
| `--color-violet` | `#9900CC` | Accent. Links, active states, the spiral mark. |
| `--color-lilac` | `#EDE4F7` | Soft fills, icon chips. |
| `--color-paper` | `#FBFAFD` | Page background. |

Typography: **Inter** (900 for display, per "Inter Display Black") and **Jost** for body text —
Jost is the web stand-in for the brand's Futura Md BT.

The concentric-arc **brand pattern** from the brand document is reproduced as a tiling SVG background
(`.brand-pattern`, `.brand-pattern-ink` in `resources/css/app.css`). The spiral **mark** is an inline SVG
component (`<x-mark />`) so it stays crisp at any size; raster logo files live in `public/images/brand/`.

---

## Business model in the code

From `assets/GrowSphere Solutions Limited (1).pdf` and `assets/Growsphere Community Business Strategy (1).pdf`:

- **Agency side** — 8 service lines (`services`), a portfolio (`projects`), enquiries (`bookings`).
- **Community side** — 3-week cohort programmes run every 2 months (`cohorts`), self-paced skill
  courses with advanced tiers (`courses`), one-on-one mentorship (a `bookings` type), certificates.
- **Content** — insights/announcements (`posts`), quotes (`testimonials`), newsletter signups
  (`subscribers`), plus the Substack embed.

---

## Admin

**http://growth.test/admin** — seeded login:

```
growspheresolutions2@gmail.com / growsphere
```

> Change this password before the site goes anywhere public.

Everything dynamic on the site is editable there: services, work, cohorts, courses, insights,
testimonials, the enquiry inbox, subscribers (with CSV export), and **Site settings** — hero copy,
stats, mission/vision, founder bio, contact details, social links and the Substack URLs.

Clearing `substack_embed_url` in Site settings removes every Substack embed across the site.

---

## Substack

`https://growspherecommunity.substack.com/embed` is rendered by the `<x-substack-embed />` component,
which is placed on **Home**, **Community**, **Insights**, **each post**, **each cohort** and **Contact**,
and linked from the footer. The iframe is forced to `width: 100%` so it stays responsive
(`.substack-frame iframe`). Both URLs are admin-editable.

Publishing a post here does **not** push it to Substack — the two are independent.

---

## Local development

```bash
composer install && npm install && npm run build
```

Rebuild assets after changing Blade or CSS (Tailwind scans the Blade files):

```bash
npm run build
```

Reset the database to seeded demo content:

```bash
php artisan migrate:fresh --seed
```

---

## Notes

- Uploads go to `storage/app/public` and are served through the `public/storage` symlink.
- Contact and subscribe endpoints are rate-limited and use a honeypot field.
- `.reveal` scroll animations are scoped to `.js`, so content stays visible if JavaScript fails.
- Motion respects `prefers-reduced-motion`.
- `assets/` holds the original source PDFs and logo files; `resources/design/grow.reference.html` is
  the original static mock, kept for reference only — it is not served.
