# Kirby and Vite Template

## Features

#### The following features are shamelessly stolen from [Arnoson's kirby-vite kit](https://github.com/arnoson/kirby-vite-multi-page-kit) 

- ⚡️ Uses [Vite](https://vitejs.dev/) with [kirby-vite](https://github.com/arnoson/kirby-vite) plugin
- 📚 Multiple pages
- 🔄 Live Reloading for Kirby templates, snippets, content, ... changes
- 📂 [Public folder structure](https://getkirby.com/docs/guide/configuration#custom-folder-setup__public-folder-setup)


#### The following features are added to provide a structured setup and some predefined elements

- 🧩 Predefined components
- 🎨 Predefined SCSS structure:
  - abstracts
  - typographic styling
  - variable setup
  - utility classes
  - custom built grid system`src/assets/scss/grid.scss`
  - scaleable structure
- ✂️ Predefined `site/snippets` structure:
  - `./page-structure.php`
  - `./components/`
  - `./parts/`
  - `./blocks/`
- 🗺️ Predefined `site/blueprints` structure:
  - `./files/`
  - `./fields/`
  - `./sections/`
  - `./users/`
  - `./blocks/`
- 🌐 Extends Kirby's layout field
  - `~/components/layout.php`
  - `~/blueprints/fields/layout.yml`
  - uses writer field styles for text content `~/components/writer-field.scss`
  - Uses the grid system `~/utility/grid.scss` to structure the layout entries
- 🔌 Helper Functions Plugin
  - `~/site/plugins/kb-helpers`
  - Add functions to the plugin to the `lib` folder (They are publicly accessible)
  - The layout component uses the `convertFractionToClass` function


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

## Use the preset structure

The heart of this template is the `site/snippets/page-structure.php`.
It must be used in every `site/templates` and provides the whole page structure and exposes different `slots()` to add content to the `<main>`, `<head>`, `<header>`, `<footer>` and `<foot>` of the page.

In `site/templates/default.php` you can find a all use of the `slots()` method for this snippet.  
  
  
#### Use The Following Slots:

`slot('default')`   → inside `<main>`
  
`slot('head')`      → inside `<head>` (add page specific `<link>`, `<script>`, `<meta>` etc.)
  
`slot('header')`    → inside `<header>`  
  
`slot('footer')`    → inside `<footer>`  
  
`slot('foot')`      → right before the `<body>` tag closes (add page specific `<link>`, `<script>`, `<meta>` etc.)   

#### Arrows
```
<span class="arrow" data-direction="left"></span>
```
The following keywords for `data-direction` work:
- `left`
- `right`
- `up`
- `down`
- `up-left`
- `down-left`
- `up-right`
- `down-right`


## Deployment

### Manually

Upload the repository to your web server and point your web server to the repository's `public` folder.

### Rsync

If you have ssh access you can use rsync to automate the upload/sync.

### Git

You can also deploy your repository with git. Then you have to run the [installation](#installation) steps again on your web server.

## File Nesting

If your are using VS Code, you can add file nesting to visually organize your assets in the editor's file explorer:

```json
// .vscode/settings.json
{
  "explorer.fileNesting.enabled": true,
  "explorer.fileNesting.patterns": {
    "*.js": "${capture}.css"
  },
}
```

## Versioning

Because this is a started kit and not a library it doesn't use semantic versioning.
If you wan't to migrate an existing project please look for any breaking changes in the release note.