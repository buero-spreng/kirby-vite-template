# Kirby and Vite Template

## Features

These features are shamelessly stolen by [Arnoson's kirby-vite kit](https://github.com/arnoson/kirby-vite-multi-page-kit) 

- ⚡️ Uses [Vite](https://vitejs.dev/) with [kirby-vite](https://github.com/arnoson/kirby-vite) plugin
- 📚 Multiple pages
- 🔄 Live Reloading for Kirby templates, snippets, content, ... changes
- 📂 [Public folder structure](https://getkirby.com/docs/guide/configuration#custom-folder-setup__public-folder-setup)

- 🧩 Predefined components
- 🎨 Predefined SCSS structure:
  - abstracts
  - typographic styling
  - variable setup
  - utility classes
  - custom built grid
  - scaleable structure
- ✂️ Predefined `site/snippets` structure:
  - `site/snippets/page-structure.php`
  - components library
  - page parts
  - blocks library
- 🗺️ Predefined `site/blueprints` structure:
  - files
  - fields
  - sections
  - users
  - blocks


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

## How to use

The heart of this build is the `site/snippets/page-structure.php`
which must be used in every page template.  
In the `site/templates/default.php` you can find a all use of the `slots()` method for this snippet.  
  
  
#### Use The Following Slots:

`slot('default')`   most used: this will fill in content inside the `<main>` element  
  
`slot('head')`      here you can add `<link>` or `<script>` tags to the **head** of the document  
  
`slot('header')`    here you can ad elements to display in the **header** of the page (often unused)  
  
`slot('footer')`    here you can ad elements to display in the **footer** of the page (often unused)  
  
`slot('foot')`      here you can add `<link>` or `<script>` tags right before the `<body>` tag closes  

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

## Versioning

Because this is a started kit and not a library it doesn't use semantic versioning.
If you wan't to migrate an existing project please look for any breaking changes in the release note.
