# Kirby and Vite Template

#### The following features are shamelessly stolen from [Arnoson's kirby-vite kit](https://github.com/arnoson/kirby-vite-multi-page-kit) 

- ⚡️ Uses [Vite](https://vitejs.dev/) with [kirby-vite](https://github.com/arnoson/kirby-vite) plugin
- 📚 Multiple pages
- 🔄 Live Reloading for Kirby templates, snippets, content, ... changes
- 📂 [Public folder structure](https://getkirby.com/docs/guide/configuration#custom-folder-setup__public-folder-setup)

## Additional Features

- 🧱 Opinionated page shell via `site/snippets/page-structure.php` with slot-based sections
- 🧩 Layout field extension that maps Kirby fractions to a custom CSS grid
- 🗂️ Curated blueprints, fields, file types and user roles for common site needs
- 🎨 SCSS architecture (abstracts, utilities, components) plus writer-friendly typography
- 🔌 Helper plugin and panel skin to keep panel output and frontend grid in sync

## Installation

Clone this repository and run:

```
composer install
```

```
npm install
```

## Development

Start vite's dev server and a simple php dev server by running:

```
npm run dev
```

Visit `localhost:8888` in the browser. Vite's dev server (`localhost:5173`) is only used for serving js, css and assets.

## Preview

Get a local production preview by running:

```
npm run preview
```

## Production

Build your optimized frontend assets to `public/dist`:

```
npm run build
```

## Frontend build & asset loading

- Vite is preconfigured in `vite.config.js` with `vite-plugin-kirby` to serve/build everything inside `src`, including per-template bundles from `src/templates/*.js`.
- The Kirby Vite plugin lives in `site/plugins/kirby-vite`; `site/config/vite.config.php` is auto-generated so Kirby knows where to find `public/dist`.
- `site/snippets/page-structure.php` injects shared assets via `vite()->js('main.js')` / `vite()->css('main.js')` and tries to load template-specific assets (e.g. `templates/home.js`) automatically.

## Page shell & navigation

- Every template calls `snippet('page-structure', slots: true)` and fills named `slot()`s for `head`, `header`, `default`, `footer`, and `foot`, keeping markup consistent across pages (`site/templates/*.php`).
- The header pulls a minimal navigation component (`site/snippets/components/menu.php`) that lists all non-error pages and marks the active one.
- Favicons are generated server-side from the `siteIcon` field through `site/snippets/parts/favicons.php`, which derives `.ico`, `.svg`, and Apple touch icons on the fly.

## Layout field & grid system

- The layout field blueprint (`site/blueprints/fields/layout.yml`) defines a set of column combinations that mirror the custom grid fractions.
- `site/snippets/components/layout.php` renders layout columns into a `.kb-grid` container and translates Kirby’s `1/2`-style widths into responsive classes through `kbResponsiveClassesFromFraction()` from the helper plugin.
- The grid itself is defined in `src/assets/scss/utilities/grid.scss`: 24-column base with fraction utilities (`col-1-2`, `col-1-3-lg`, etc.) generated for all breakpoints from `abstracts/breakpoints.scss`.
- Legacy grid helpers remain in `src/assets/scss/utilities/old-grid.scss` if you need the previous `column-*` API.

## Blocks & content components

- Text blocks reuse the custom writer field (`site/blueprints/fields/writer.yml`) with a slim toolbar; frontend typography for writer output is styled via `.writer-fields` in `src/assets/scss/components/writer-field.scss`.
- Image blocks (`site/blueprints/blocks/image.yml` + `site/snippets/blocks/image.php`) support internal/external sources, optional ratios/cropping, links, captions, and set `aspect-ratio` on the rendered `<figure>`.
- A Glide-ready gallery renderer lives in `site/snippets/blocks/gallery.php` with matching styles in `src/assets/scss/components/gallery.scss`; it applies a configurable ratio and includes arrow/bullet controls that hook into Glide’s classes.
- Utility arrows (`src/assets/scss/components/arrows.scss`) power the arrow spans referenced in templates and the gallery navigation.

## Blueprint structure & panel tweaks

- Blueprints are organized by type (`site/blueprints/{pages,files,fields,sections,tabs,users}`) to encourage reuse: e.g. `fields/alignment.yml`, `fields/mobile-display.yml`, and `fields/site-icon.yml`.
- Default pages (`site/blueprints/pages/default.yml`) expose a writer field; legal/error pages have tailored presets; the site blueprint separates main pages from “background” pages via tabs and uses the shared `settings`/`media` tab partials.
- File blueprints for images/PDFs enforce alt/caption metadata. User roles (`site/blueprints/users/*.yml`) set granular panel permissions and share the `sections/user-info.yml` fields.
- Panel appearance is customized through `public/assets/css/custom-panel.css`, registered in `site/config/config.php`.
- Environment-specific config is split (`site/config/config.php` vs `site/config/config.localhost.php`) so debug mode stays local.

## Styling system

- SCSS is structured under `src/assets/scss/`:
  - `abstracts/` for breakpoints, mixins, and type scales.
  - `utilities/` for CSS variables, spacing helpers, grid utilities, and generic utility classes.
  - `components/` for arrows, buttons, images, writer content, and gallery styling.
  - `layout/` for global defaults plus header/footer shells; `base/` for resets, typography, and link styles.
- Shared styles compile from `src/assets/scss/main.scss`; template-specific overrides live next to each entry (e.g. `src/templates/home.js` loads `src/assets/scss/home.scss`).

## Helper plugin

- `site/plugins/kb-helpers` registers shared PHP utilities; currently it exposes `kbResponsiveClassesFromFraction()` (`lib/kbResponsiveClassesFromFraction.php`) to keep Kirby layout widths aligned with the SCSS grid.
- Add more shared helpers to the `lib/` folder and import them where needed; they are available globally once the plugin loads.

