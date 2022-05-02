# Valiant Web Starter Theme for WordPress

A lightweight WordPress starter theme that utilizes TailwindCSS.

Requirements:
- `npm`

Run the following commands to install the necessary `npm` packages:

```
npm install
```

Once the packages are installed, run the following commands to either build (CSS and JS) or watch for changes (PHP, HTML, CSS, and JS files) respectively:

```
npm run build
npm run start
```

## Editing the theme

All assets can be found in the `src` folder. JavaScript in `src` folder is handled by webpack which is called by gulp in parallel with handling the styles. You can find the processed JS and CSS files in `dist` folder which is then loaded via enqueue scripts/styles in `functions.php`.

WordPress theme setup, menus, and sidebars are registered in `functions.php`.

## What the theme is not

This theme is not aimed for developers who planned on releasing a theme for public use: like uploading it to WordPress theme repository or building a commercial theme. 